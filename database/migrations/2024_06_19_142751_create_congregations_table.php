<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongregationsTable extends Migration
{
    public function up()
    {
        Schema::create('congregations', function (Blueprint $table) {
            $table->id();
            $table->string('nome_principal');
            $table->string('nomes_alternativos')->nullable();
            $table->string('siglas')->nullable();
            $table->string('familia_final')->nullable();
            $table->string('genero')->nullable();  // Alterado de char(1) para string
            $table->text('fontes')->nullable();
            $table->text('datas_aprovacao')->nullable();
            $table->text('anos_reformulacao')->nullable();
            $table->text('situacao_canonica')->nullable();
            $table->date('data_fundacao')->nullable();
            $table->string('pais_fundacao')->nullable();
            $table->string('cidade_fundacao')->nullable();
            $table->string('chegada_brasil_estado')->nullable();
            $table->string('chegada_brasil_municipio')->nullable();
            $table->integer('membros_brasil')->nullable();
            $table->integer('irmaos')->nullable();
            $table->integer('postulantes')->nullable();
            $table->integer('novicos')->nullable();
            $table->text('carisma')->nullable();
            $table->text('motivos_vinda')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('congregations');
    }
}


