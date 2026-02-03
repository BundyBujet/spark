<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            'Admins & Roles',
            // admins
            'Admins',
            'All Admins',
            'Add Admin',
            'Edit Admin',
            'Show Admin',
            'Delete Admin',
            //roles
            'Roles',
            'All Roles',
            'Add Role',
            'Edit Role',
            'Show Role',
            'Delete Role',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}
