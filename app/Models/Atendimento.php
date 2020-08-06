<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $fillable = [
        'forma',
        'situacao',
        'agendamento_id',
        'pessoa_id',
        'colaborador_id'
    ];

    public function agendamento()
    {
        return $this->belongsTo(\App\Models\Agendamento::class, 'agendamento_id');
    }

    public function pessoa()
    {
        return $this->belongsTo(\App\Models\Pessoa::class, 'pessoa_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(\App\Models\Colaborador::class, 'colaborador_id');
    }
    
}
