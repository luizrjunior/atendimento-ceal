<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Bloqueio;
use Illuminate\Http\Request;

class BloqueioController extends Controller
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
        $bloqueios = Bloqueio::all();
        return view('cadastros.bloqueios.index', compact('bloqueios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.bloqueios.create');
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
            'nome' => 'required|string|max:60|unique:bloqueios',
            'descricao' => 'nullable|string|max:255',
            'atividade_id' => 'required',
            'horario_id' => 'required',
            'data_inicio' => 'required|date_format:d/m/Y',
            'data_fim' => 'nullable|date_format:d/m/Y'
        ]);

        $encoding = mb_internal_encoding();
        $data_inicio = \DateTime::createFromFormat('d/m/Y', $request->data_inicio)->format('Y-m-d');
        $data_fim = \DateTime::createFromFormat('d/m/Y', $request->data_fim)->format('Y-m-d');

        $bloqueio = new Bloqueio([
            'nome' => mb_strtoupper($request->nome, $encoding),
            'descricao' => $request->get('descricao'),
            'horario_id' => $request->horario_id,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim
        ]);
        $bloqueio->save();

        return redirect('/bloqueios/' . $bloqueio->id . '/edit')->with('success', 'Bloqueio adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bloqueio  $bloqueio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bloqueio = Bloqueio::find($id);
        return view('cadastros.bloqueios.edit', compact('bloqueio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bloqueio  $bloqueio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:60|unique:bloqueios,nome,' . $id . ',id',
            'descricao' => 'nullable|string|max:255',
            'atividade_id' => 'required',
            'horario_id' => 'required',
            'data_inicio' => 'required|date_format:d/m/Y',
            'data_fim' => 'nullable|date_format:d/m/Y'
        ]);

        $encoding = mb_internal_encoding();
        $data_inicio = \DateTime::createFromFormat('d/m/Y', $request->data_inicio)->format('Y-m-d');
        $data_fim = \DateTime::createFromFormat('d/m/Y', $request->data_fim)->format('Y-m-d');

        $bloqueio = Bloqueio::find($id);
        $bloqueio->nome = mb_strtoupper($request->get('nome'), $encoding);
        $bloqueio->descricao = $request->get('descricao');
        $bloqueio->horario_id = $request->horario_id;
        $bloqueio->data_inicio = $data_inicio;
        $bloqueio->data_fim = $data_fim;
        $bloqueio->save();

        return redirect('/bloqueios/' . $bloqueio->id . '/edit')->with('success', 'Bloqueio alterado com sucesso!');
    }

}
