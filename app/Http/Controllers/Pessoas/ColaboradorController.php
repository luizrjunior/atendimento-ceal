<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Colaborador;

class ColaboradorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colaboradors = Colaborador::all();
        return view('pessoas.colaboradors.index', compact('colaboradors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pessoas.colaboradors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required|string|max:255|unique:colaboradors'
          ]);
  
          $colaborador = new Colaborador([
            'nome' => $request->get('nome')
          ]);
          $colaborador->save();
  
          return redirect('/colaboradors/' . $colaborador->id . '/edit')->with('success', 'Colaborador adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colaborador = Colaborador::find($id);
        return view('pessoas.colaboradors.edit', compact('colaborador'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome'=>'required|string|max:255|unique:colaboradors,nome,' . $id . ',id'
        ]);
  
        $colaborador = Colaborador::find($id);
        $colaborador->nome = $request->get('nome');
        $colaborador->save();
  
        return redirect('/colaboradors/' . $colaborador->id . '/edit')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function ativarDesativarColaborador(Request $request) {
        $colaborador = Colaborador::find($request->colaborador_id);
        $msg = "Colaborador ativado com sucesso!";
        $situacao = 1;
        if ($colaborador->situacao == 1) {
            $msg = "Colaborador desativado com sucesso!";
            $situacao = 2;
        }
        $colaborador->situacao = $situacao;
        $colaborador->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
