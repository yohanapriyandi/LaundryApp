<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use App\User;

class RolePermissionController extends Controller
{
    public function getAllRole()
    {
        $roles = Role::all();
        return response()->json(['status' => 'success', 'data' => $roles], 200);
    }

    public function getAllPermission()
    {
        $permission = Permission::all();
        return response()->json(['status' => 'success', 'data' => $permission], 200);
    }

    public function getRolePermission(Request $request)
    {
        $hasPermission = DB::table('role_has_permissions')
            ->select('permissions.name')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id' )
            ->where('role_id', $request->role_id)->get();
            return response()->json(['status' => 'success', 'data' => $hasPermission], 200);
    }

    public function setRolePermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|exists:roles. id'
        ]);
        $role = Role::find($request->role_id);
        $role->syncPermission($request->permission);
        return response()->json(['status' => 'success'], 200);
    }

    public function  setRoleUser(Request $request)
    {
        $this->validate([
            'user_id' => 'required|exists:users, id',
            'role' => 'required'
        ]);
        $user = User::find($request->user_id);
        $user->syncRoles([$request->role]);
        return response()->json(['status' => 'success'], 200);
    }

}
