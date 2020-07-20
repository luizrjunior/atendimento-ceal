<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orientacao extends Model
{
    public $table = 'orientacoes';

    protected $fillable = [
        'situacao',
        'descricao'
    ];
}
