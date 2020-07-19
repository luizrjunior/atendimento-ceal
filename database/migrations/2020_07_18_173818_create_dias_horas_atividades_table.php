<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiasHorasAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dias_horas_atividades', function (Blueprint $table) {
            $table->id();
            $table->integer('situacao')->default(1);
            $table->integer('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_termino');
            $table->unsignedBigInteger('atividade_id');
            $table->foreign('atividade_id')->references('id')->on('atividades')->onDelete('cascade');
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
        Schema::dropIfExists('dias_horas_atividades');
    }
}
