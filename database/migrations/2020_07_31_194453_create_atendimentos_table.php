<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->integer('situacao')->default(1); // 1=Agendado;2=Cancelado;3=Continua;4=Liberado
            $table->integer('forma')->default(1); // 1=Virtual;2=Presencial;3=A distancia

            $table->unsignedBigInteger('agendamento_id');
            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('cascade');

            $table->unsignedBigInteger('pessoa_id');
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade');

            $table->unsignedBigInteger('colaborador_id')->nullable();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atendimentos');
    }
}
