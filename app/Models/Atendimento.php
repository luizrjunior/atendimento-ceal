<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $fillable = [
        'forma',
        'situacao',
        'observacoes',
        'numero_vagas_virtual',
        'numero_vagas_presencial',
        'numero_vagas_distancia',
        'numero_espera_virtual',
        'numero_espera_presencial',
        'numero_espera_distancia',
        'horario_id',
        'paciente_id',
        'atendente_id',
        'data_atendimento',
    ];

    public function horario()
    {
        return $this->belongsTo(\App\Models\Horario::class, 'horario_id');
    }

    public function paciente()
    {
        return $this->belongsTo(\App\Models\Pessoa::class, 'paciente_id');
    }

    public function atendente()
    {
        return $this->belongsTo(\App\Models\Pessoa::class, 'atendente_id');
    }
    
}
