<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    public $table = 'locais';

    protected $fillable = [
      'situacao',
      'nome',
      'numero'
    ];
}
