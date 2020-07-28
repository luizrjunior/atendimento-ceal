@extends('layouts.app')

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
                    Meu Dados de Usuário
                </div>
                <div class="card-body">
                    @include('components.alertas')
                    <form method="post" action="{{ route('my-profile.update') }}">
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
                            <button type="submit" class="btn btn-primary">
                                Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card uper">
                <div class="card-header">
                    Meus Perfis de Usuário
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><b>Perfil</b></td>
                                <td><b>Descrição</b></td>
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
                            </tr>
                            @endforeach
                            @if (count($usersHasRoles) == 0)
                            <tr>
                                <td colspan="3">Nenhum registro encontrado!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card uper">
                <div class="card-header">
                    Alterar Senha
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('my-profile.update-password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection