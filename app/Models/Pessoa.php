<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [
        'cpf',
        'nome',
        'nascimento',
        'sexo',
        'telefone',
        'profissao',
        'socio',
        'bairro',
        'user_id'
      ];
}
