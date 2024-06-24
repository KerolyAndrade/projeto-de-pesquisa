<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('congregations', function (Blueprint $table) {
            $table->id();
            $table->string('nome_principal');
            $table->string('nomes_alternativos')->nullable();
            $table->string('siglas')->nullable();
            $table->string('familia_final')->nullable();
            $table->string('genero')->nullable();
            $table->string('fontes')->nullable();
            $table->date('data_aprovacao_constituicoes')->nullable();
            $table->date('data_aprovacao_regras')->nullable();
            $table->date('data_aprovacao_dir_diocesano')->nullable();
            $table->date('data_aprovacao_dir_pontificio')->nullable();
            $table->date('data_aprovacao_decretum_laudis')->nullable();
            $table->string('anos_reformulacao_constituicoes')->nullable();
            $table->string('situacao_canonica')->nullable();
            $table->date('data_fundacao')->nullable();
            $table->string('pais_fundacao')->nullable();
            $table->string('cidade_fundacao')->nullable();
            $table->string('chegada_brasil_estado')->nullable();
            $table->string('chegada_brasil_municipio')->nullable();
            $table->integer('membros_brasil')->nullable();
            $table->integer('irmaos_as')->nullable();
            $table->integer('postulantes')->nullable();
            $table->integer('novicos')->nullable();
            $table->string('carisma')->nullable();
            $table->string('motivos_vinda')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('congregations');
    }
};
