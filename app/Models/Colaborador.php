<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    public $table = 'colaboradores';

    protected $fillable = [
        'situacao',
        'pessoa_id'
    ];
    
    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'pessoa_id');
    }

}
