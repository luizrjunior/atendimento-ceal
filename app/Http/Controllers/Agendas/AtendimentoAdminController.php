<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Atendimento;

class AtendimentoAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function filtrosPesquisa($request)
    {
        $data = $request->except('_token');
        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['situacao_psq'])) {
            $data['situacao_psq'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        return $data;
    }

    public function index(Request $request)
    {
        $data = $this->filtrosPesquisa($request);

        $atendimentos = Atendimento::paginate($data['totalPage']);
        return view('agendas.atendimentos-admin.index', compact('data', 'atendimentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
