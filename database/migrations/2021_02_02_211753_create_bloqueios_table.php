<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloqueiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloqueios', function (Blueprint $table) {
            $table->id();
            $table->integer('situacao')->default(1); // 1=Ativado;2=Desativado;

            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');

            $table->unsignedBigInteger('bloqueador_id')->nullable();
            $table->foreign('bloqueador_id')->references('id')->on('pessoas')->onDelete('cascade');

            $table->date('data_inicio');
            $table->date('data_fim')->nullable();

            $table->string('nome');
            $table->string('descricao');

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
        Schema::dropIfExists('bloqueios');
    }
}
