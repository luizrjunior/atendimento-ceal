@php
$disabled = "";
@endphp
@if ($role->id == 1)
    @php
    $disabled = "disabled";
    @endphp
@endif

@extends('layouts.app')

@section('javascript')
<script>
    top.routeLoadPermissionsRoleJson = "{{ route('roles.load-permissions-role-json') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/acl/roles-has-permissions/roles-has-permissions.js') }}"></script>
@endsection

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
    .DocumentList {
        overflow-x:hidden;
        overflow-y:scroll;
        height:300px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card uper">
                <div class="card-header">
                    Editar Perfil de Usuário
                    <a href="{{ url('roles') }}" class="float-right">
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

                    <form method="post" action="{{ route('roles.update', $role->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $role->name }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <input id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $role->description }}" autocomplete="description">
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" {{$disabled}}>
                                Atualizar
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card uper">
                <div class="card-header">
                    Permissões do Perfil
                </div>
                <div class="card-body">

                    <form method="post" action="{{ route('roles.store-role-has-permission') }}">
                        @csrf
                        <input type="hidden" id="role_id" name="role_id" value="{{ $role->id }}">
                        <div class="DocumentList">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" id="checkTodos" name="checkTodos"></td>
                                        <td><b>Permissão</b></td>
                                        <td><b>Descrição</b></td>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                    $permissionController = new \App\Http\Controllers\Acl\PermissionController();
                                    $permissions = $permissionController->loadPermissions();

                                    $roleHasPermissionController = new \App\Http\Controllers\Acl\RoleHasPermissionController();
                                    $rolesHasPermissions = $roleHasPermissionController->loadPermissionsRole($role->id);

                                    $arrPermissionsId = [];
                                    foreach ($rolesHasPermissions as $roleHasPermission) {
                                        $arrPermissionsId[] = $roleHasPermission->permission_id;
                                    }
                                    @endphp

                                    @foreach($permissions as $permission)
                                        @php
                                        $checked = "";
                                        @endphp
                                        @if (count($rolesHasPermissions) > 0)
                                            @if (in_array($permission->id, $arrPermissionsId))
                                                @php
                                                $checked = "checked";
                                                @endphp
                                            @endif
                                        @endif
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="permissao" value="{{ $permission->id }}" name="permission_id[]" {{ $checked }}>
                                        </td>
                                        <td>{{$permission->name}}</td>
                                        <td>{{$permission->description}}</td>
                                    </tr>
                                    @endforeach
                
                                    @if (count($permissions) == 0)
                                    <tr>
                                        <td colspan="4">Nenhum registro encontrado!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" {{$disabled}}>
                                Salvar  
                            </button>
                        </div>

                    </form>

                <div>
            <div>


        </div>
    </div>
</div>
@endsection