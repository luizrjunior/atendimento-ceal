<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class MyProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        return view('acl.my-profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user_id = Auth::id();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id . ',id'
        ]);

        $user = User::find($user_id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();

        return redirect('/my-profile')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        $user_id = Auth::id();
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::find($user_id);
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect('/my-profile')->with('success', 'Senha atualizada com sucesso!');
    }

}
