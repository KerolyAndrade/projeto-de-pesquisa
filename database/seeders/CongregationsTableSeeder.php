<?php

namespace Database\Seeders;

use App\Models\Congregation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CongregationsTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Congregation::truncate();
        Schema::enableForeignKeyConstraints();

        $filePath = database_path('seeders/banco.csv');

        if (!File::exists($filePath)) {
            $this->command->error("CSV file not found at: {$filePath}");
            return;
        }

        $file = fopen($filePath, 'r');

        if (!$file) {
            $this->command->error("Failed to open CSV file: {$filePath}");
            return;
        }

        $header = fgetcsv($file); // Lê o cabeçalho do CSV (não usado diretamente)

        // Arrays para armazenar os dados únicos dos campos específicos do CSV
        $paises_fundacao = [];
        $paises_presente = [];
        $estados_presente = [];

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            // Coleta os dados de cada linha do CSV conforme necessário
            $data = array_map('trim', $data); // Remove espaços em branco

            if (count($data) < 46) { // Verifica se a linha tem pelo menos 46 colunas (ajuste conforme seu CSV)
                $this->command->error("Incomplete row found in CSV file: " . implode(',', $data));
                continue;
            }

            $fontes = $this->truncateString($data[0]);
            $familia_final = $this->truncateString($data[1]);
            $nome_principal = $this->truncateString($data[2]);
            $nomes_alternativos = $this->truncateString($data[3]);
            $siglas = $this->truncateString($data[4]);
            $pais_fundacao = $this->truncateString($data[5]);
            $genero = $this->truncateString($data[6]);
            $situacao_canonica = $this->truncateString($data[7]);
            $pais_presente = isset($data[43]) ? $this->truncateString($data[43]) : null;
            $estados_presente = isset($data[45]) ? $this->truncateString($data[45]) : null;
            $updated_at = now();
            $created_at = now();

            // Verifica se a congregação já existe no banco de dados antes de criá-la
            $existingCongregation = Congregation::where('nome_principal', $nome_principal)->first();

            if ($existingCongregation) {
                // Atualiza a congregação existente
                $existingCongregation->update([
                    'fontes' => $fontes,
                    'familia_final' => $familia_final,
                    'nomes_alternativos' => $nomes_alternativos,
                    'siglas' => $siglas,
                    'pais_fundacao' => $pais_fundacao,
                    'genero' => $genero,
                    'situacao_canonica' => $situacao_canonica,
                    'pais_presente' => $pais_presente,
                    'estados_presente' => $estados_presente,
                    'updated_at' => $updated_at,
                ]);
            } else {
                // Cria a congregação no banco de dados
                Congregation::create([
                    'fontes' => $fontes,
                    'familia_final' => $familia_final,
                    'nome_principal' => $nome_principal,
                    'nomes_alternativos' => $nomes_alternativos,
                    'siglas' => $siglas,
                    'pais_fundacao' => $pais_fundacao,
                    'genero' => $genero,
                    'situacao_canonica' => $situacao_canonica,
                    'pais_presente' => $pais_presente,
                    'estados_presente' => $estados_presente,
                    'updated_at' => $updated_at,
                    'created_at' => $created_at,
                ]);
            }
        }

        fclose($file);

        // Exibe mensagem de sucesso ou informações necessárias
        $this->command->info('Congregations table seeded successfully.');
    }

    private function truncateString($value, $limit = 255)
    {
        return mb_substr($value, 0, $limit);
    }
}
