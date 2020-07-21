<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeTemDiaHora extends Model
{
    public $table = 'atividades_tem_dias_horas';

    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_termino',
        'atividade_id'
    ];
}
