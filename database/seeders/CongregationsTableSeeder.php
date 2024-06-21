<?php

namespace Database\Seeders;

use App\Models\Congregation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CongregationsTableSeeder extends Seeder
{
    public function run()
{
    // Truncate the table first
    Schema::disableForeignKeyConstraints();
    Congregation::truncate();
    Schema::enableForeignKeyConstraints();

    // Read the CSV file
    $file = fopen(database_path('seeders/banco.csv'), 'r');
    $header = fgetcsv($file); // Skip the header row

    while (($data = fgetcsv($file, 1000, ',')) !== false) {
        // Mapear os índices das colunas conforme os dados fornecidos
        $congregationData = [
            'fontes' => $this->truncateString($data[0]),
            'familia_final' => $this->truncateString($data[1]),
            'nome_principal' => $this->truncateString($data[2]),
            'nomes_alternativos' => $this->truncateString($data[3]),
            'siglas' => $this->truncateString($data[4]),
            // Continue mapeando os campos conforme necessário
            // Exemplo:
            // 'data_aprovacao_constituicoes' => $this->formatDate($data[5]),
            // 'data_aprovacao_regras' => $this->formatDate($data[6]),
            // ...
        ];

        // Inserir no banco de dados usando Query Builder
        DB::table('congregations')->insert($congregationData);
    }

    fclose($file);
}

    private function truncateString($value, $limit = 255)
    {
        return mb_substr($value, 0, $limit);
    }

    private function formatDate($value)
    {
        // Implemente a lógica para formatar a data conforme necessário
        return $value; // Exemplo simples, ajuste conforme a necessidade real
    }

    // Outros métodos de formatação e validação aqui...
}

