<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $fillable = [
        'situacao',
        'descricao'
    ];
}
