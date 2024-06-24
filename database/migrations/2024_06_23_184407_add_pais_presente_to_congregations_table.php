<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaisPresenteToCongregationsTable extends Migration
{
    public function up()
    {
        Schema::table('congregations', function (Blueprint $table) {
            $table->string('pais_presente')->nullable()->after('chegada_brasil_municipio');
            // Você pode ajustar o tipo e as opções da coluna conforme necessário
        });
    }

    public function down()
    {
        Schema::table('congregations', function (Blueprint $table) {
            $table->dropColumn('pais_presente');
        });
    }
}
