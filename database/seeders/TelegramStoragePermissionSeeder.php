<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TelegramStoragePermissionSeeder extends Seeder
{
    /**
     * Add "Manage Telegram Storage" permission if not exists and assign to Owner role.
     */
    public function run(): void
    {
        $permission = Permission::firstOrCreate(
            ['name' => 'Manage Telegram Storage', 'guard_name' => 'admin']
        );

        $owner = Role::where('name', 'Owner')->where('guard_name', 'admin')->first();
        if ($owner && ! $owner->hasPermissionTo($permission)) {
            $owner->givePermissionTo($permission);
        }
    }
}
