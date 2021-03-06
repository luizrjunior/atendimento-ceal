@php
$disabled = "";
@endphp
@if ($user->id == 1)
    @php
    $disabled = "disabled";
    @endphp
@endif

@extends('layouts.app')

@section('javascript')
<script>
    top.routeLoadPermissionsRoleJson = "{{ route('roles.load-permissions-role-json') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/acl/users/edit-user.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card uper">
                <div class="card-header">
                    Editar Usuário
                    <a href="{{ url('users') }}" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Voltar
                    </a>
                </div>
                <div class="card-body">

                    @include('components.alertas')
                    
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" {{$disabled}}>
                                Atualizar
                            </button>
                            {{-- <a href="{{ url('users/create') }}" class="btn btn-primary">
                                Novo
                            </a> --}}
                        </div>
                    </form>

                </div>
            </div>

            <div id="divCardListRolesUser" class="card uper">
                <div class="card-header">
                    Perfis do Usuário
                    <a href="#" onclick="abrirCard(2)" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Associar Novo Perfil ao Usuário
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nome do Perfil</td>
                                <td>Descrição</td>
                                <td>Ações</td>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $userHasRoleController = new \App\Http\Controllers\Acl\UserHasRoleController();
                            $usersHasRoles = $userHasRoleController->loadRolesUser($user->id);
                            @endphp

                            @foreach($usersHasRoles as $userHasRole)
                            <tr>
                                <td>{{$userHasRole->role->name}}</td>
                                <td>{{$userHasRole->role->description}}</td>
                                <td>
                                    <form action="{{ route('users.destroy-user-has-role') }}" method="post">
                                      @csrf
                                      @method('DELETE')
                                      <input type="hidden" id="uhr_user_id" name="uhr_user_id" value="{{ $user->id }}">
                                      <input type="hidden" id="uhr_role_id" name="uhr_role_id" value="{{ $userHasRole->role->id }}">
                                      <button class="btn btn-danger btn-sm" type="submit" {{$disabled}}>Remover</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
        
                            @if (count($usersHasRoles) == 0)
                            <tr>
                                <td colspan="4">Nenhum registro encontrado!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="divCardAddRoleUser" class="card uper">
                <div class="card-header">
                    Adicionar Perfil do Usuário
                    <a href="#" onclick="abrirCard(1)" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('users.store-user-has-role') }}">
                        @csrf

                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">

                        <div class="form-group">
                            <label for="role_id">Perfil de Usuário</label>
                            <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                                <option value=""> - - SELECIONE - - </option>

                                @php
                                $roleController = new \App\Http\Controllers\Acl\RoleController();
                                $roles = $roleController->loadComboRoles();
                                @endphp

                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="permissoes">Permissões do Perfil</label>
                            <textarea class="form-control" id="permissoes" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" {{$disabled}}>
                                Adicionar
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection