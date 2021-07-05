<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends Controller
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
        $roles = Role::all();
        return view('acl.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('acl.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles'
        ]);

        $role = new Role([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
        $role->save();

        return redirect('/roles/' . $role->id . '/edit')->with('success', 'Perfil adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('acl.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id . ',id'
        ]);

        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->save();

        return redirect('/roles/' . $role->id . '/edit')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function loadComboRoles()
    {
        return Role::all();
    }
}
