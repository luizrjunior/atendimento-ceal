<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtendimentoHasOrientacao extends Model
{
    public $table = 'atendimentos_has_orientacoes';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'atendimento_id',
        'orientacao_id'
    ];
    
    public function orientacao()
    {
        return $this->belongsTo('App\Models\Orientacao', 'orientacao_id');
    }

}
