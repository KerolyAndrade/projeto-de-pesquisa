<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Congregation;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CongregationsTableSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('seeders/banco.csv'), 'r');
        $header = fgetcsv($file, 0, ',');
        $rowNumber = 1;

        DB::beginTransaction();
        Log::info('Seeder started');

        try {
            while (($data = fgetcsv($file, 0, ',')) !== false) {
                $rowNumber++;
                $row = array_combine($header, $data);
                Log::info('Processing row: ' . $rowNumber . ' - Data: ' . json_encode($row));

                // Normalizar Data de fundação
                if (isset($row['Data de fundação'])) {
                    if (preg_match('/^\d{4}$/', $row['Data de fundação'])) {
                        $row['Data de fundação'] .= '-01-01';
                    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $row['Data de fundação']) === 0) {
                        $row['Data de fundação'] = null;
                    }
                }

                // Normalização de valores vazios
                foreach ($row as $key => $value) {
                    if (trim($value) === '') {
                        $row[$key] = null;
                    }
                }

                // NÃO NORMALIZAR O CAMPO 'Membros no Brasil' - Não tratar como numérico
                $row['Membros no Brasil\n (Preferência para informações do AC2015)'] = $row['Membros no Brasil\n (Preferência para informações do AC2015)'] ?? null;

                // Normalizar campos numéricos (exceto Membros no Brasil)
                $numericFields = [
                    'Fundadores M', 'Fundadores F', 'COM Hierarquia M', 'COM hierarquia F',
                    'SEM Hierarquia M', 'SEM Hierarquia F', 'Santo/M', 'Santo/F',
                    'Nº de membros do grupo fundador - Religiosos', 'Nº de membros do grupo fundador - Leigos',
                    'Nº de membros do grupo fundador - Não Especificado', 'Período de funcionamento - Casas no Brasil [fontes]',
                    'Período de funcionamento - Casas Fechadas', 'Estados onde está presente', 'Nº de estados onde está presente',
                    'Nº de casas no mundo', 'Países onde está presente', 'Nº de países onde está presente',
                    'Sacerdotes *', 'Irmãos/ãs *',
                    'Postulantes *', 'Noviços *', 'Dados Alternativos\n(com fontes) *', 'Membros no mundo (total)',
                    'Organização Hierárquica/ Administrativa - Nomeação?', 'Organização Hierárquica/ Administrativa - Eleição?',
                    'Organização Hierárquica/ Administrativa - Ambos?', 'Publicações de uso Interno', 'Publicações livres',
                    'Total de Publicações *', 'Obras sobre a Congregação', 'Total', 'Número de fontes Manuscritas'
                ];

                foreach ($numericFields as $field) {
                    if (isset($row[$field])) {
                        // Verifica se o campo é numérico, se não, substitui por 0
                        if (!is_numeric($row[$field]) || trim($row[$field]) === '') {
                            $row[$field] = 0;
                        }
                    }
                }

                // Normalizar e remover duplicatas nas famílias finais
                if (isset($row['Família final'])) {
                    $row['Família final'] = $this->normalizeFamiliaFinal($row['Família final']);
                }

                // Inserir ou atualizar dados da congregação
                $congregation = Congregation::updateOrCreate(
                    ['nome_principal' => $row['NOME PRINCIPAL'] ?? null],
                    [
                        'nomes_alternativos' => $row['NOMES ALTERNATIVOS'] ?? null,
                        'siglas' => $row['SIGLAS'] ?? null,
                        'familia_final' => $row['Família final'] ?? null,
                        'genero' => $this->normalizeGenero($row['M/F?'] ?? null),
                        'datas_aprovacao' => $row['Datas de Aprovação'] ?? null,
                        'anos_reformulacao' => $row['Anos de reformulação'] ?? null,
                        'situacao_canonica' => $row['Situação canônica'] ?? null,
                        'data_fundacao' => $row['Data de fundação'] ?? null,
                        'pais_fundacao' => $row['País de Fundação'] ?? null,
                        'cidade_fundacao' => $row['Cidade de Fundação'] ?? null,
                        'chegada_brasil_estado' => $this->normalizeEstado($row['Chegada ao Brasil - Estado'] ?? null),
                        'chegada_brasil_municipio' => $row['Chegada ao Brasil - Município'] ?? null,
                        'membros_brasil' => $row['Membros no Brasil\n (Preferência para informações do AC2015)'], // Não tratar como numérico
                        'irmaos' => $row['Irmãos/ãs *'] ?? 0,
                        'postulantes' => $row['Postulantes *'] ?? 0,
                        'novicos' => $row['Noviços *'] ?? 0,
                        'carisma' => $row['Carisma'] ?? null,
                        'motivos_vinda' => $row['Motivos da vinda'] ?? null,
                    ]
                );

                // Processar e associar URLs de fontes
                if (isset($row['FONTES'])) {
                    Log::info('Original URLs: ' . $row['FONTES']); // Log original das URLs
                    $urls = $this->processUrls($row['FONTES']);
                    Log::info('Processed URLs: ' . json_encode($urls)); // Log das URLs processadas

                    foreach ($urls as $url) {
                        $source = Source::firstOrCreate(['url' => $url]);
                        $congregation->sources()->syncWithoutDetaching($source->id);
                    }
                }
            }
            DB::commit(); // Commit da transação
            Log::info('Seeder executed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error inserting row $rowNumber: " . json_encode($row) . " - Error: " . $e->getMessage());
        }

        fclose($file);
    }

    private function processUrls($urls)
    {
        preg_match_all('/(http[s]?:\/\/[^\[\]]+)/', $urls, $matches);
        $urlsArray = array_map('trim', $matches[1]);
        $processedUrls = [];

        foreach ($urlsArray as $url) {
            $url = trim($url);
            if (!preg_match('/^https?:\/\//', $url)) {
                $url = 'http://' . $url;
            }

            $url = filter_var($url, FILTER_SANITIZE_URL);
            if (filter_var($url, FILTER_VALIDATE_URL) && strlen($url) <= 2000) {
                $processedUrls[] = $url;
            } else {
                Log::warning("Invalid URL detected and ignored: '{$url}'");
            }
        }

        return $processedUrls;
    }

    private function normalizeGenero($genero)
    {
        if (empty($genero)) {
            return null;
        }

        $genero = strtoupper(trim($genero));

        if ($genero === 'M' || $genero === 'F') {
            return $genero;
        }

        return null;
    }

    private function normalizeEstado($estado)
    {
        if (empty($estado)) {
            return null;
        }

        // Criar um mapeamento para as siglas dos estados
        $estadoMap = [
            'Acre' => 'AC', 'Alagoas' => 'AL', 'Amazonas' => 'AM', 'Bahia' => 'BA',
            'Ceará' => 'CE', 'Espírito Santo' => 'ES', 'Goiás' => 'GO', 'Maranhão' => 'MA',
            'Mato Grosso' => 'MT', 'Mato Grosso do Sul' => 'MS', 'Minas Gerais' => 'MG',
            'Pará' => 'PA', 'Paraíba' => 'PB', 'Paraná' => 'PR', 'Pernambuco' => 'PE',
            'Piauí' => 'PI', 'Rio de Janeiro' => 'RJ', 'Rio Grande do Norte' => 'RN',
            'Rio Grande do Sul' => 'RS', 'Rondônia' => 'RO', 'Roraima' => 'RR', 'Santa Catarina' => 'SC',
            'São Paulo' => 'SP', 'Sergipe' => 'SE', 'Tocantins' => 'TO'
        ];

        // Retornar a sigla ou o valor original, caso não haja sigla
        return $estadoMap[ucwords(strtolower(trim($estado)))] ?? strtoupper(trim($estado));
    }

    private function normalizeFamiliaFinal($familiaFinal)
    {
        // Remover espaços extras e normalizar o valor para maiúsculas
        $familiaFinal = strtoupper(trim($familiaFinal));

        // Se já estiver normalizado, não faz nada
        return $familiaFinal;
    }
}
