<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
  
  public $table = 'funcoes';

  protected $fillable = [
      'situacao',
      'nome'
    ];
}
