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
        // CRUD
        if ($request->module && $request->actions) {
            foreach ($request->actions as $action) {
                Permission::firstOrCreate([
                    'name' => $request->module . '.' . $action
                ]);
            }
        }

        // CUSTOM (bebas)
        if ($request->custom) {
            $permissions = explode(',', $request->custom);

            foreach ($permissions as $perm) {
                $perm = trim($perm);

                if ($perm) {
                    Permission::firstOrCreate([
                        'name' => $perm
                    ]);
                }
            }
        }

        return back()->with('success', 'Permission berhasil dibuat');
    }
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Permission berhasil diupdate');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission berhasil dihapus');
    }
}