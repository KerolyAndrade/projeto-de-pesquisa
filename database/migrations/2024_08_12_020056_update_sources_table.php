<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->text('url')->change(); // Altere o tipo de varchar(255) para text
        });
    }
    
    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->string('url', 255)->change(); // Reverter a alteração
        });
    }
    
};
