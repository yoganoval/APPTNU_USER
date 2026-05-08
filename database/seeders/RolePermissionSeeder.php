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
        // RESET CACHE
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // CLEAR DATA
        Permission::query()->delete();
        Role::query()->delete();

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // DASHBOARD
            'dashboard.view',

            // USER
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // ROLE
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // PERMISSION
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',

            // =====================
            // CERTIFICATE SYSTEM 🔥
            // =====================

            // TEMPLATE
            'certificate.template.view',
            'certificate.template.create',
            'certificate.template.edit',
            'certificate.template.delete',

            // EDIT FIELD
            'certificate.edit',

            // GENERATE
            'certificate.generate',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $anggota = Role::firstOrCreate([
            'name' => 'anggota',
            'guard_name' => 'web',
        ]);


        /*
        |--------------------------------------------------------------------------
        | ASSIGN PERMISSIONS
        |--------------------------------------------------------------------------
        */

        // ADMIN → semua akses
        $admin->syncPermissions(Permission::all());

        // ANGGOTA → basic
        $anggota->syncPermissions([
            'dashboard.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN USER
        |--------------------------------------------------------------------------
        */

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