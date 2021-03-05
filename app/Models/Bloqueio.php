<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloqueio extends Model
{
    public $table = 'bloqueios';

    protected $fillable = [
        'situacao',
        'nome',
        'descricao',
        'horario_id',
        'bloqueador_id',
        'data_inicio',
        'data_fim'
      ];

    public function horario()
    {
        return $this->belongsTo(\App\Models\Horario::class, 'horario_id');
    }

    public function bloqueador()
    {
        return $this->belongsTo(\App\Models\Pessoa::class, 'bloqueador_id');
    }

}
