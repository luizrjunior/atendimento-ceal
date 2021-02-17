<?php

namespace App\Http\Controllers\Atendimentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AtendimentoHasMotivo;

class AtendimentoHasMotivoController extends Controller
{
    public function loadMotivosAtendimento($atendimento_id)
    {
        return AtendimentoHasMotivo::select('motivo_id')->where('atendimento_id', $atendimento_id)->get();
    }

    public function loadMotivosAtendimentoJson(Request $request)
    {
        $atendimentos_has_motivos = AtendimentoHasMotivo::select('motivos.descricao')->where('atendimentos_has_motivos.atendimento_id', $request->atendimento_id)
            ->join('motivos', 'atendimentos_has_motivos.motivo_id', 'motivos.id')->get();
        return response()->json($atendimentos_has_motivos, 200);
    }

    public function store(Request $request)
    {
        AtendimentoHasMotivo::where('atendimento_id', $request->atendimento_id)->delete();
        $motivos = isset($request->motivo_id) ? $request->motivo_id : [];
        if (count($motivos) > 0) {
            $i = 0;
            $atendimento_has_motivo = [];
            foreach ($motivos as $motivo) {
                $atendimento_has_motivo[$i] = new AtendimentoHasMotivo([
                    'atendimento_id' => $request->get('atendimento_id'),
                    'motivo_id'=> $motivo
                ]);
                $atendimento_has_motivo[$i]->save();
            }
        }
        return redirect('/atendimentos-admin/' . $request->atendimento_id . '/edit')->with('success', 'Motivos associadas/removidas com sucesso!');
    }

}
