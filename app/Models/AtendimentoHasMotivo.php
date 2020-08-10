<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtendimentoHasMotivo extends Model
{
    public $table = 'atendimentos_has_motivos';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'atendimento_id',
        'motivo_id'
    ];
    
    public function motivo()
    {
        return $this->belongsTo('App\Models\Motivo', 'motivo_id');
    }

}
