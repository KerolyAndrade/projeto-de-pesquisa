<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->timestamps();
        });

        Schema::create('congregation_source', function (Blueprint $table) {
            $table->foreignId('congregation_id')->constrained()->onDelete('cascade');
            $table->foreignId('source_id')->constrained()->onDelete('cascade');
            $table->primary(['congregation_id', 'source_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('congregation_source');
        Schema::dropIfExists('sources');
    }
}
