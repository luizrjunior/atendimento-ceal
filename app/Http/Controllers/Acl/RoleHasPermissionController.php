<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoleHasPermission;

class RoleHasPermissionController extends Controller
{
    public function loadPermissionsRole($role_id)
    {
        return RoleHasPermission::select('permission_id')->where('role_id', $role_id)->get();
    }

    public function loadPermissionsRoleJson(Request $request)
    {
        $roles_has_permissions = RoleHasPermission::select('permissions.name')->where('roles_has_permissions.role_id', $request->role_id)
            ->join('permissions', 'roles_has_permissions.permission_id', 'permissions.id')->get();
        return response()->json($roles_has_permissions, 200);
    }

    public function store(Request $request)
    {
        RoleHasPermission::where('role_id', $request->role_id)->delete();
        $permissions = isset($request->permission_id) ? $request->permission_id : [];
        if (count($permissions) > 0) {
            $i = 0;
            $role_has_permission = [];
            foreach ($permissions as $permission) {
                $role_has_permission[$i] = new RoleHasPermission([
                    'role_id' => $request->get('role_id'),
                    'permission_id'=> $permission
                ]);
                $role_has_permission[$i]->save();
            }
        }
        return redirect('/roles/' . $request->role_id . '/edit')->with('success', 'Permissões associadas/removidas com sucesso!');
    }

}
