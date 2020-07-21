<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTemFuncoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores_tem_funcoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('colaborador_id');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->unsignedBigInteger('funcao_id');
            $table->foreign('funcao_id')->references('id')->on('funcoes')->onDelete('cascade');
            $table->primary(['colaborador_id', 'funcao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colaboradores_tem_funcoes');
    }
}
