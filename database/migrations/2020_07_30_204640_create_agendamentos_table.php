<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->integer('situacao')->default(1);
            $table->integer('numero_vagas_distancia')->default(0);
            $table->integer('numero_vagas_virtual')->default(0);
            $table->integer('numero_vagas_presencial')->default(0);
            $table->integer('numero_espera_virtual')->default(0);
            $table->integer('numero_espera_presencial')->default(0);
            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
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
        Schema::dropIfExists('agendamentos');
    }
}
