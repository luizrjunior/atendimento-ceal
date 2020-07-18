<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Local;

class LocalController extends Controller
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
        $locals = Local::all();
        return view('cadastros.locals.index', compact('locals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.locals.create');
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
            'nome'=>'required|string|max:255|unique:locals',
            'numero'=>'required|string|max:255'
          ]);
  
          $local = new Local([
            'nome' => $request->get('nome'),
            'numero' => $request->get('numero')
          ]);
          $local->save();
  
          return redirect('/locals/' . $local->id . '/edit')->with('success', 'Local adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $local = Local::find($id);
        return view('cadastros.locals.edit', compact('local'));
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
            'nome'=>'required|string|max:255|unique:locals,nome,' . $id . ',id',
            'numero'=>'required|string|max:255'
        ]);
  
        $local = Local::find($id);
        $local->nome = $request->get('nome');
        $local->numero = $request->get('numero');
        $local->save();
  
        return redirect('/locals/' . $local->id . '/edit')->with('success', 'Local atualizado com sucesso!');
    }

    public function ativarDesativarLocal(Request $request) {
        $local = Local::find($request->local_id);
        $msg = "Local ativado com sucesso!";
        $situacao = 1;
        if ($local->situacao == 1) {
            $msg = "Local desativado com sucesso!";
            $situacao = 2;
        }
        $local->situacao = $situacao;
        $local->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
