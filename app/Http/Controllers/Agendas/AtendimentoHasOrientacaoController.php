<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AtendimentoHasOrientacao;

class AtendimentoHasOrientacaoController extends Controller
{

    public function loadOrientacoesAtendimento($atendimento_id)
    {
        return AtendimentoHasOrientacao::select('orientacao_id')->where('atendiment_id', $atendimento_id)->get();
    }

    public function loadOrientacoesAtendimentoJson(Request $request)
    {
        $atendimentos_has_orientacoes = AtendimentoHasOrientacao::select('orientacoes.descricao')->where('atendimentos_has_orientacoes.atendiment_id', $request->atendimento_id)
            ->join('orientacoes', 'atendimentos_has_orientacoes.orientacao_id', 'orientacoes.id')->get();
        return response()->json($atendimentos_has_orientacoes, 200);
    }

    public function store(Request $request)
    {
        AtendimentoHasOrientacao::where('atendiment_id', $request->atendimento_id)->delete();
        $orientacoes = isset($request->orientacao_id) ? $request->orientacao_id : [];
        if (count($orientacoes) > 0) {
            $i = 0;
            $atendimento_has_orientacao = [];
            foreach ($orientacoes as $orientacao) {
                $atendimento_has_orientacao[$i] = new AtendimentoHasOrientacao([
                    'atendiment_id' => $request->get('atendimento_id'),
                    'orientacao_id'=> $orientacao
                ]);
                $atendimento_has_orientacao[$i]->save();
            }
        }
        return redirect('/atendimentos-admin/' . $request->atendimento_id . '/edit')->with('success', 'Orientacões associadas/removidas com sucesso!');
    }

}
