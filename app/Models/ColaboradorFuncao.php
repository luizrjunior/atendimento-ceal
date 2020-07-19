<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColaboradorFuncao extends Model
{
    public $table = 'colaboradores_funcoes';

    protected $fillable = [
        'colaborador_id',
        'funcao_id'
    ];
}
