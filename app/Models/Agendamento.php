<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'data',
        'situacao',
        'numero_vagas_virtual',
        'numero_vagas_presencial',
        'numero_espera_virtual',
        'numero_espera_presencial',
        'horario_id'
    ];

    public function horario()
    {
        return $this->belongsTo(\App\Models\Horario::class, 'horario_id');
    }

}
