<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $fillable = [
      'situacao',
      'nome',
      'numero'
    ];
}
