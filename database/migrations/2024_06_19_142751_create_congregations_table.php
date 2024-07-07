<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('congregations', function (Blueprint $table) {
        $table->id();
        $table->string('fontes')->nullable();
        $table->string('familia_final')->nullable();
        $table->string('nome_principal');
        $table->string('nomes_alternativos')->nullable();
        $table->string('siglas')->nullable();
        $table->string('tem_formulario_preenchido')->nullable();
        $table->string('existe')->nullable();
        $table->string('existe_brasil')->nullable();
        $table->string('genero')->nullable();
        $table->string('possui_mantenedora')->nullable();
        $table->string('fundadores_m')->nullable();
        $table->string('fundadores_f')->nullable();
        $table->string('com_hierarquia_m')->nullable();
        $table->string('com_hierarquia_f')->nullable();
        $table->string('sem_hierarquia_m')->nullable();
        $table->string('sem_hierarquia_f')->nullable();
        $table->string('santo_m')->nullable();
        $table->string('santo_f')->nullable();
        $table->string('nomes_fundadores')->nullable();
        $table->string('datas_aprovacao')->nullable();
        $table->string('anos_reformulacao_constituicoes')->nullable();
        $table->string('situacao_canonica')->nullable();
        $table->date('data_fundacao')->nullable();
        $table->string('pais_fundacao')->nullable();
        $table->string('estado_fundacao')->nullable();
        $table->string('cidade_fundacao')->nullable();
        $table->integer('chegada_brasil_ano')->nullable();
        $table->string('chegada_brasil_estado')->nullable();
        $table->string('chegada_brasil_municipio')->nullable();
        $table->integer('membros_grupo_fundador_religiosos')->nullable();
        $table->integer('membros_grupo_fundador_leigos')->nullable();
        $table->integer('membros_grupo_fundador_nao_especificado')->nullable(); // Add this line
        $table->string('periodo_funcionamento_casas_brasil')->nullable();
        $table->string('periodo_funcionamento_casas_fechadas')->nullable();
        $table->string('estados_presente')->nullable();
        $table->integer('num_estados_presente')->nullable();
        $table->integer('num_casas_mundo')->nullable();
        $table->string('paises_presente')->nullable();
        $table->integer('num_paises_presente')->nullable();
        $table->integer('sacerdotes')->nullable();
        $table->integer('irmaos_as')->nullable();
        $table->integer('postulantes')->nullable();
        $table->integer('novicos')->nullable();
        $table->integer('membros_mundo_total')->nullable();
        $table->string('organizacao_hierarquica_nomeacao')->nullable();
        $table->string('organizacao_hierarquica_eleicao')->nullable();
        $table->string('organizacao_hierarquica_ambos')->nullable();
        $table->string('publicacoes_uso_interno')->nullable();
        $table->string('publicacoes_livres')->nullable();
        $table->string('total_publicacoes')->nullable();
        $table->string('obras_sobre_congregacao')->nullable();
        $table->string('total')->nullable();
        $table->string('num_fontes_manuscritas')->nullable();
        $table->string('carisma')->nullable();
        $table->string('missao_fundacao')->nullable();
        $table->string('missao_hoje')->nullable();
        $table->string('motivos_vinda')->nullable();
        $table->string('trabalhos_assumidos')->nullable();
        $table->string('notas')->nullable();
        $table->string('sede_brasil_cidade')->nullable();
        $table->string('sede_brasil_estado')->nullable();
        $table->integer('sede_brasil_capital')->nullable();
        $table->float('taxa_reproducao')->nullable();
        $table->float('proporcao_membros_formacao')->nullable();
        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('congregations');
    }
};