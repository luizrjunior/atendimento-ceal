<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Motivo;

class MotivoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $motivos = Motivo::all();
        return view('cadastros.motivos.index', compact('motivos'));
    }

    public function create()
    {
        return view('cadastros.motivos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255|unique:motivos'
        ]);

        $encoding = mb_internal_encoding();

        $motivo = new Motivo([
            'descricao' => mb_strtoupper($request->get('descricao'), $encoding)
        ]);
        $motivo->save();

        return redirect('/motivos/' . $motivo->id . '/edit')->with('success', 'Motivo adicionado com sucesso!');
    }

    public function edit($id)
    {
        $motivo = Motivo::find($id);
        return view('cadastros.motivos.edit', compact('motivo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255|unique:motivos,descricao,' . $id . ',id'
        ]);

        $encoding = mb_internal_encoding();

        $motivo = Motivo::find($id);
        $motivo->descricao = mb_strtoupper($request->get('descricao'), $encoding);
        $motivo->save();

        return redirect('/motivos/' . $motivo->id . '/edit')->with('success', 'Motivo atualizado com sucesso!');
    }

    public function ativarDesativarMotivo(Request $request)
    {
        $motivo = Motivo::find($request->motivo_id);
        $msg = "Motivo ativado com sucesso!";
        $situacao = 1;
        if ($motivo->situacao == 1) {
            $msg = "Motivo desativado com sucesso!";
            $situacao = 2;
        }
        $motivo->situacao = $situacao;
        $motivo->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarMotivos()
    {
        return Motivo::all();
    }

}
