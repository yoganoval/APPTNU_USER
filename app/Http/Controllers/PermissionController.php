<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return inertia('Permissions/Index', [
            'permissions' => Permission::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back();
    }
}
