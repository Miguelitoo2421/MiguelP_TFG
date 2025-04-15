<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Opcional: Limpiar la caché de permisos para asegurar que no haya conflictos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear el rol 'admin'
        Role::create(['name' => 'admin']);

        // Crear el rol 'user'
        Role::create(['name' => 'user']);
    }
}
