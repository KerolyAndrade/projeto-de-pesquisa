<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatisfactionSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('satisfaction_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('instituicao');
            $table->string('finalidade');
            $table->text('experiencia');
            $table->text('sugestoes')->nullable();
            $table->text('informacoes_congregacao')->nullable();
            $table->string('anexo')->nullable();
            $table->boolean('consentimento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('satisfaction_surveys');
    }
}
