<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Congregation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CongregationsTableSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('seeders/banco.csv'), 'r');
        $header = fgetcsv($file, 0, ',');

        $rowNumber = 1; // Para rastrear o número da linha

        while (($data = fgetcsv($file, 0, ',')) !== false) {
            $rowNumber++;
            $row = array_combine($header, $data);

            // Tratamento de datas para garantir que estejam no formato YYYY-MM-DD
            if (isset($row['Data de fundação'])) {
                if (preg_match('/^\d{4}$/', $row['Data de fundação'])) {
                    // Se o valor for um ano, converte para o formato YYYY-01-01
                    $row['Data de fundação'] = $row['Data de fundação'] . '-01-01';
                } elseif (preg_match('/^\d+$/', $row['Data de fundação'])) {
                    // Se o valor for um número (mas não um ano de 4 dígitos), converte para o formato YYYY-01-01
                    $row['Data de fundação'] = str_pad($row['Data de fundação'], 4, '0', STR_PAD_LEFT) . '-01-01';
                }
            }

            // Substituir valores não numéricos por null ou valores padrão
            $integerFields = [
                'Membros no Brasil\n (Preferência para informações do AC2015)',
                'Irmãos/ãs *', 
                'Postulantes *', 
                'Noviços *'
            ];

            foreach ($integerFields as $field) {
                if (isset($row[$field]) && !is_numeric($row[$field])) {
                    $row[$field] = null;
                }
            }

            // Substituir valores não informados por null
            foreach ($row as $key => $value) {
                if ($value === 'N/E' || $value === 'N/I' || trim($value) === '') {
                    $row[$key] = null;
                }
            }

            try {
                Congregation::create([
                    'nome_principal' => $row['NOME PRINCIPAL'] ?? null,
                    'nomes_alternativos' => $row['NOMES ALTERNATIVOS'] ?? null,
                    'siglas' => $row['SIGLAS'] ?? null,
                    'familia_final' => $row['Família final'] ?? null,
                    'genero' => $row['M/F?'] ?? null,
                    'fontes' => $row['Fontes'] ?? null,
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
                ]);
            } catch (\Exception $e) {
                Log::error("Erro ao inserir linha $rowNumber: " . json_encode($row) . " - Erro: " . $e->getMessage());
            }
        }

        fclose($file);
    }
}

