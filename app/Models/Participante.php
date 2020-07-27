<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $fillable = [
        'horario_id',
        'colaborador_id',
        'funcao_id'
    ];

    public function colaborador()
    {
        return $this->belongsTo(\App\Models\Colaborador::class, 'colaborador_id');
    }

    public function funcao()
    {
        return $this->belongsTo(\App\Models\Funcao::class, 'funcao_id');
    }
}
