<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadosPresenteToCongregationsTable extends Migration
{
    public function up()
    {
        Schema::table('congregations', function (Blueprint $table) {
            $table->string('estados_presente')->nullable()->after('cidade_fundacao');
            // Você pode ajustar o tipo e as opções da coluna conforme necessário
        });
    }

    public function down()
    {
        Schema::table('congregations', function (Blueprint $table) {
            $table->dropColumn('estados_presente');
        });
    }
}
