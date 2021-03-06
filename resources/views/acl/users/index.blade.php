@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="card uper">

        <div class="card-header">
            Lista de Usuários
            {{-- <a href="{{ url('users/create') }}" class="float-right">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Adicionar Usuário
            </a> --}}
        </div>

        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Cadastrado em</b></td>
                        <td><b>Nome</b></td>
                        <td><b>E-mail</b></td>
                        <td><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{date('d/m/Y H:i:s', strtotime($user->created_at))}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Editar</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        <div>

    <div>
<div>
@endsection