<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrador = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $empleado = Role::create([
            'name' => 'empleado',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'admin.index',
            'guard_name' => 'web',
        ])->assignRole($administrador);

        Permission::create([
            'name' => 'admin.create',
            'guard_name' => 'web',
        ])->assignRole($administrador);
        
        Permission::create([
            'name' => 'admin.store',
            'guard_name' => 'web',
        ])->assignRole($administrador);

        Permission::create([
            'name' => 'admin.edit',
            'guard_name' => 'web',
        ])->assignRole($administrador);

        Permission::create([
            'name' => 'admin.destroy',
            'guard_name' => 'web',
        ])->assignRole($administrador);

        Permission::create([
            'name' => 'employees.index',
            'guard_name' => 'web',
        ])->assignRole($administrador);

        Permission::create([
            'name' => 'employees.store',
            'guard_name' => 'web',
        ])->syncRoles([$administrador, $empleado]);

    }
}
