<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\UserHasRole;

class UserHasRoleController extends Controller
{
    const MESSAGES_ERRORS = [	
        'role_id.required' => 'O Perfil de Usuário precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'role_id.unique' => 'O Perfil de Usuário informado já está associado para este usuário. Por favor, '
        . 'você pode verificar isso?',
    ];

    public function loadRolesUser($user_id)
    {
        return UserHasRole::where('user_id', $user_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => [
                'required',
                Rule::unique('users_has_roles')->where('user_id', $request->user_id),
            ],
        ], self::MESSAGES_ERRORS);
  
        $user_has_role = new UserHasRole([
            'user_id' => $request->get('user_id'),
            'role_id'=> $request->get('role_id')
        ]);
        $user_has_role->save();

        return redirect('/users/' . $request->user_id . '/edit')->with('success', 'Perfil de Usuário associado com sucesso!');
    }

    public function destroy(Request $request)
    {
         UserHasRole::where('user_id', $request->user_id)->where('role_id', $request->role_id)->delete();
         return redirect('/users/' . $request->user_id . '/edit')->with('success', 'Perfil de Usuário removido com sucesso!');
    }

}
