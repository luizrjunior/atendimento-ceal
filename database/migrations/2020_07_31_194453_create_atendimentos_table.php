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
            $table->integer('situacao')->default(1); // 1=Agendado;2-Em Fila de Espera;3=Cancelado;4=Concluído;5=Liberado
            $table->integer('forma')->default(0); // 0=Indefinito;1=Virtual;2=Presencial;3=A distancia

            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');

            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pessoas')->onDelete('cascade');

            $table->unsignedBigInteger('atendente_id')->nullable();
            $table->foreign('atendente_id')->references('id')->on('pessoas')->onDelete('cascade');

            $table->date('data_atendimento');
            $table->string('observacoes')->nullable();

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
