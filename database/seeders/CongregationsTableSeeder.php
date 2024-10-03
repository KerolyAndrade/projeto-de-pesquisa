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

        $rowNumber = 1; // Para rastrear o número da linha

        DB::beginTransaction(); // Inicia uma transação

        Log::info('Seeder started');

        try {
            while (($data = fgetcsv($file, 0, ',')) !== false) {
                $rowNumber++;
                $row = array_combine($header, $data);

                Log::info('Processing row: ' . $rowNumber . ' - Data: ' . json_encode($row));

                // Corrigir valores inválidos para a data
                if (isset($row['Data de fundação'])) {
                    if (preg_match('/^\d{4}$/', $row['Data de fundação'])) {
                        $row['Data de fundação'] .= '-01-01';
                    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $row['Data de fundação']) === 0) {
                        $row['Data de fundação'] = null; // Corrigir para NULL se não for uma data válida
                    }
                }

                // Corrigir outros campos inválidos
                foreach ($row as $key => $value) {
                    if (trim($value) === '') {
                        $row[$key] = null;
                    }
                }

                // Substituir valores numéricos
                $numericFields = [
                    'Fundadores M', 
                    'Fundadores F', 
                    'COM Hierarquia M',
                    'COM hierarquia F',
                    'SEM Hierarquia M',
                    'SEM Hierarquia F',
                    'Santo/M',
                    'Santo/F',
                    'Nº de membros do grupo fundador - Religiosos',
                    'Nº de membros do grupo fundador - Leigos',
                    'Nº de membros do grupo fundador - Não Especificado',
                    'Período de funcionamento - Casas no Brasil [fontes]',
                    'Período de funcionamento - Casas Fechadas',
                    'Estados onde está presente',
                    'Nº de estados onde está presente',
                    'Nº de casas no mundo',
                    'Países onde está presente',
                    'Nº de países onde está presente',
                    'Membros no Brasil\n (Preferência para informações do AC2015)',
                    'Sacerdotes *',
                    'Irmãos/ãs *',
                    'Postulantes *',
                    'Noviços *',
                    'Dados Alternativos\n(com fontes) *',
                    'Membros no mundo (total)',
                    'Organização Hierárquica/ Administrativa - Nomeação?',
                    'Organização Hierárquica/ Administrativa - Eleição?',
                    'Organização Hierárquica/ Administrativa - Ambos?',
                    'Publicações de uso Interno',
                    'Publicações livres',
                    'Total de Publicações *',
                    'Obras sobre a Congregação',
                    'Total',
                    'Número de fontes Manuscritas'
                ];

                foreach ($numericFields as $field) {
                    if (isset($row[$field]) && !is_numeric($row[$field])) {
                        $row[$field] = null;
                    } else {
                        $row[$field] = $row[$field] ?? 0;
                    }
                }

                // Inserir ou atualizar dados da congregação
                $congregation = Congregation::updateOrCreate(
                    ['nome_principal' => $row['NOME PRINCIPAL'] ?? null],
                    [
                        'nomes_alternativos' => $row['NOMES ALTERNATIVOS'] ?? null,
                        'siglas' => $row['SIGLAS'] ?? null,
                        'familia_final' => $row['Família final'] ?? null,
                        'genero' => $row['M/F?'] ?? null,
                        'datas_aprovacao' => $row['Datas de Aprovação'] ?? null,
                        'anos_reformulacao' => $row['Anos de reformulação'] ?? null,
                        'situacao_canonica' => $row['Situação canônica'] ?? null,
                        'data_fundacao' => $row['Data de fundação'] ?? null,
                        'pais_fundacao' => $row['País de Fundação'] ?? null,
                        'cidade_fundacao' => $row['Cidade de Fundação'] ?? null,
                        'chegada_brasil_estado' => $row['Chegada ao Brasil - Estado'] ?? null,
                        'chegada_brasil_municipio' => $row['Chegada ao Brasil - Município'] ?? null,
                        'membros_brasil' => $row['Membros no Brasil\n (Preferência para informações do AC2015)'] ?? null,
                        'irmaos' => $row['Irmãos/ãs *'] ?? null,
                        'postulantes' => $row['Postulantes *'] ?? null,
                        'novicos' => $row['Noviços *'] ?? null,
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
            DB::rollBack(); // Rollback em caso de erro
            Log::error("Error inserting row $rowNumber: " . json_encode($row) . " - Error: " . $e->getMessage());
        }

        fclose($file);
    }

    
    private function processUrls($urls)
    {
        // Usar expressão regular para separar URLs com base em padrões conhecidos
        preg_match_all('/(http[s]?:\/\/[^\[\]]+)/', $urls, $matches);
    
        // Obter todas as URLs encontradas
        $urlsArray = array_map('trim', $matches[1]);
        $processedUrls = [];
    
        foreach ($urlsArray as $url) {
            $url = trim($url);
    
            // Adicionar esquema http:// se não estiver presente
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
    
        return $processedUrls; // Retornar URLs válidas como um array
    }
    


}

