<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToCongregationsTable extends Migration
{
    public function up()
    {
        Schema::table('congregations', function (Blueprint $table) {
            if (!Schema::hasColumn('congregations', 'data_aprovacao_constituicoes')) {
                $table->string('data_aprovacao_constituicoes')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'data_aprovacao_regras')) {
                $table->string('data_aprovacao_regras')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'data_aprovacao_dir_diocesano')) {
                $table->string('data_aprovacao_dir_diocesano')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'data_aprovacao_dir_pontificio')) {
                $table->string('data_aprovacao_dir_pontificio')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'data_aprovacao_decretum_laudis')) {
                $table->string('data_aprovacao_decretum_laudis')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'ano_reformulacao_constituicoes')) {
                $table->string('ano_reformulacao_constituicoes')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'situacao_canonica')) {
                $table->string('situacao_canonica')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'data_fundacao')) {
                $table->string('data_fundacao')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'pais_fundacao')) {
                $table->string('pais_fundacao')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'cidade_fundacao')) {
                $table->string('cidade_fundacao')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'chegada_brasil_estado')) {
                $table->string('chegada_brasil_estado')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'chegada_brasil_municipio')) {
                $table->string('chegada_brasil_municipio')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'membros_brasil')) {
                $table->integer('membros_brasil')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'irmaos_as')) {
                $table->integer('irmaos_as')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'postulantes')) {
                $table->integer('postulantes')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'novicos')) {
                $table->integer('novicos')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'carisma')) {
                $table->string('carisma')->nullable();
            }
            if (!Schema::hasColumn('congregations', 'motivos_vinda')) {
                $table->string('motivos_vinda')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('congregations', function (Blueprint $table) {
            $table->dropColumn([
                'data_aprovacao_constituicoes',
                'data_aprovacao_regras',
                'data_aprovacao_dir_diocesano',
                'data_aprovacao_dir_pontificio',
                'data_aprovacao_decretum_laudis',
                'ano_reformulacao_constituicoes',
                'situacao_canonica',
                'data_fundacao',
                'pais_fundacao',
                'cidade_fundacao',
                'chegada_brasil_estado',
                'chegada_brasil_municipio',
                'membros_brasil',
                'irmaos_as',
                'postulantes',
                'novicos',
                'carisma',
                'motivos_vinda',
            ]);
        });
    }
}

