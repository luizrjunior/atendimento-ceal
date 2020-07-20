<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColaboradorFuncao extends Model
{
    public $table = 'colaboradores_funcoes';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'colaborador_id',
        'funcao_id'
    ];

    public function funcao()
    {
        return $this->belongsTo(\App\Models\Funcao::class, 'funcao_id');
    }

}
