<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Pessoa;
use App\Models\Colaborador;
use App\Models\Horario;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $pessoa = Pessoa::where('user_id', $user_id)->get();
        if (count($pessoa) == 0) {
            return redirect('/pessoas/create')->with('warning', 'Conclua o registro dos seus dados cadastrais para utilizar o sistema!');
        }
        if (count($pessoa) == 1) {
            Session::put('pessoa_id', $pessoa[0]->id);
            $colaborador = Colaborador::where('pessoa_id', $pessoa[0]->id)->get();
            if (count($colaborador) > 0) {
                Session::put('colaborador_id', $colaborador[0]->id);
            }
        }

        $horarios = Horario::distinct()->where('situacao', 1)->orderBy('atividade_id')->get();

        return view('home', compact('horarios'));
    }
}
