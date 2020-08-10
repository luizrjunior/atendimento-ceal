<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendimentosHasOrientacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendimentos_has_orientacoes', function (Blueprint $table) {
            $table->unsignedBigInteger('atendiment_id');
            $table->foreign('atendiment_id')->references('id')->on('atendimentos')->onDelete('cascade');
            $table->unsignedBigInteger('orientacao_id');
            $table->foreign('orientacao_id')->references('id')->on('orientacoes')->onDelete('cascade');
            $table->primary(['atendiment_id', 'orientacao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atendimentos_has_orientacoes');
    }
}
