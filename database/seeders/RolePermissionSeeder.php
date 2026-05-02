<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // RESET CACHE SPATIE
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // CLEAR DATA
        Permission::query()->delete();
        Role::query()->delete();

        // =========================
        // PERMISSIONS (MENU ACCESS)
        // =========================
        $permissions = [
            'dashboard.view',
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'role.view',
            'role.manage',
            'permission.view',
            'permission.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::create([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        // =========================
        // ROLES
        // =========================
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $anggota = Role::create([
            'name' => 'anggota',
            'guard_name' => 'web',
        ]);

        // =========================
        // ASSIGN PERMISSIONS
        // =========================
        $admin->syncPermissions(Permission::all());

        $anggota->syncPermissions([
            'dashboard.view',
        ]);

        // =========================
        // CREATE ADMIN USER
        // =========================
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
            ]
        );

        $user->assignRole('admin');
    }
}