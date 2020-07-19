<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaHoraAtividade extends Model
{
    public $table = 'dias_horas_atividades';

    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_termino',
        'atividade_id'
    ];
}
