<?php
namespace Database\Seeders;

use App\Models\Congregation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CongregationsTableSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('seeders/banco.csv'), 'r');
        $header = fgetcsv($file); // Read the header row

        while ($row = fgetcsv($file)) {
            $data = array_combine($header, $row); // Combine header and current row into associative array

            if (!empty($data['Nome_principal'])) { // Check if 'Nome_principal' is not empty
                try {
                    $attributes = $this->mapAttributes($data); // Map CSV data to database attributes
                    Congregation::create($attributes); // Create Congregation using mapped attributes
                } catch (\Exception $e) {
                    Log::error('Erro ao inserir a congregação: ' . $e->getMessage());
                }
            } else {
                Log::warning('Tentativa de inserir registro com "nome_principal" vazio. Dados recebidos:', $data);
            }
        }

        fclose($file);
    }

    // Map CSV columns to database attributes
    private function mapAttributes($data)
    {
        $attributes = [];
        foreach ($data as $csvColumn => $value) {
            $columnName = $this->getColumnMapping($csvColumn);
            if ($columnName) {
                if ($columnName === 'data_fundacao' && !empty($value)) {
                    $attributes[$columnName] = Carbon::createFromFormat('Y-m-d', $value)->format('Y');
                } else {
                    $attributes[$columnName] = $value;
                }
            }
        }
        return $attributes;
    }

    // Função para mapear o nome da coluna CSV para o nome da coluna do banco de dados
    private function getColumnMapping($csvColumn)
    {
        $columnMapping = [
            'Fontes' => 'fontes',
            'Familia Final' => 'familia_final',
            'Nome_principal' => 'nome_principal',
            'Nomes Alternativos' => 'nomes_alternativos',
            'Siglas' => 'siglas',
            'Tem Formulário Preenchido?' => 'tem_formulario_preenchido',
            'Existe?' => 'existe',
            'Existe no Brasil?' => 'existe_brasil',
            'Gênero' => 'genero',
            'Possui Mantenedora?' => 'possui_mantenedora',
            'Fundadores M' => 'fundadores_m',
            'Fundadores F' => 'fundadores_f',
            'Com Hierarquia M' => 'com_hierarquia_m',
            'Com Hierarquia F' => 'com_hierarquia_f',
            'Sem Hierarquia M' => 'sem_hierarquia_m',
            'Sem Hierarquia F' => 'sem_hierarquia_f',
            'Santo M' => 'santo_m',
            'Santo F' => 'santo_f',
            'Nomes Fundadores' => 'nomes_fundadores',
            'Datas Aprovação' => 'datas_aprovacao',
            'Anos Reformulação Constituições' => 'anos_reformulacao_constituicoes',
            'Situação Canônica' => 'situacao_canonica',
            'Data Fundação' => 'data_fundacao',
            'País Fundação' => 'pais_fundacao',
            'Estado Fundação' => 'estado_fundacao',
            'Cidade Fundação' => 'cidade_fundacao',
            'Chegada Brasil Ano' => 'chegada_brasil_ano',
            'Chegada Brasil Estado' => 'chegada_brasil_estado',
            'Chegada Brasil Município' => 'chegada_brasil_municipio',
            'Membros Grupo Fundador Religiosos' => 'membros_grupo_fundador_religiosos',
            'Membros Grupo Fundador Leigos' => 'membros_grupo_fundador_leigos',
            'Período Funcionamento Casas Brasil' => 'periodo_funcionamento_casas_brasil',
            'Período Funcionamento Casas Fechadas' => 'periodo_funcionamento_casas_fechadas',
            'Estados Presente' => 'estados_presente',
            'Num Estados Presente' => 'num_estados_presente',
            'Num Casas Mundo' => 'num_casas_mundo',
            'Países Presente' => 'paises_presente', // Nome correto da coluna
            'Num Países Presente' => 'num_paises_presente',
            'Sacerdotes' => 'sacerdotes',
            'Irmãos/As' => 'irmaos_as',
            'Postulantes' => 'postulantes',
            'Noviços' => 'novicos',
            'Membros Mundo Total' => 'membros_mundo_total',
            'Organização Hierárquica Nomeação' => 'organizacao_hierarquica_nomeacao',
            'Organização Hierárquica Eleição' => 'organizacao_hierarquica_eleicao',
            'Organização Hierárquica Ambos' => 'organizacao_hierarquica_ambos',
            'Publicações Uso Interno' => 'publicacoes_uso_interno',
            'Publicações Livres' => 'publicacoes_livres',
            'Total Publicações' => 'total_publicacoes',
            'Obras Sobre Congregação' => 'obras_sobre_congregacao',
            'Total' => 'total',
            'Num Fontes Manuscritas' => 'num_fontes_manuscritas',
            'Carisma' => 'carisma',
            'Missão Fundação' => 'missao_fundacao',
            'Missão Hoje' => 'missao_hoje',
            'Motivos Vinda' => 'motivos_vinda',
            'Trabalhos Assumidos' => 'trabalhos_assumidos',
            'Notas' => 'notas',
            'Sede Brasil Cidade' => 'sede_brasil_cidade',
            'Sede Brasil Estado' => 'sede_brasil_estado',
            'Sede Brasil Capital' => 'sede_brasil_capital',
            'Taxa Reprodução' => 'taxa_reproducao',
            'Proporção de membros em formação em relação ao total de membros' => 'proporcao_membros_formacao',
            'updated_at' => 'updated_at',
            'created_at' => 'created_at',
        ];

        return isset($columnMapping[$csvColumn]) ? $columnMapping[$csvColumn] : null;
    }
}
