<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_termino',
        'local_id',
        'atividade_id'
    ];

    public function local()
    {
        return $this->belongsTo(\App\Models\Local::class, 'local_id');
    }
}
