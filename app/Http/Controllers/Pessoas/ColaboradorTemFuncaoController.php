<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ColaboradorTemFuncao;

class ColaboradorTemFuncaoController extends Controller
{
    public function carregarFuncoesColaborador($colaborador_id)
    {
        return ColaboradorTemFuncao::select('funcao_id')->where('colaborador_id', $colaborador_id)->get();
    }

    public function store(Request $request)
    {
        ColaboradorTemFuncao::where('colaborador_id', $request->colaborador_id)->delete();
        $funcoes = isset($request->funcao_id) ? $request->funcao_id : [];
        if (count($funcoes) > 0) {
            $i = 0;
            $colaborador_funcao = [];
            foreach ($funcoes as $permission) {
                $colaborador_funcao[$i] = new ColaboradorTemFuncao([
                    'colaborador_id' => $request->get('colaborador_id'),
                    'funcao_id'=> $permission
                ]);
                $colaborador_funcao[$i]->save();
            }
        }
        return redirect('/colaboradores/' . $request->colaborador_id . '/edit')->with('success', 'Funções associadas/removidas com sucesso!');
    }

}
