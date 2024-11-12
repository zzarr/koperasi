<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionSeeder extends Seeder
{
    public function run()
    {
        // Membuat roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Membuat permissions
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage metadata angsuran']);
        Permission::create(['name' => 'manage pembayaran simpanan pokok']);
        Permission::create(['name' => 'manage pembayaran simpanan wajib']);
        Permission::create(['name' => 'manage pembayaran simpanan hari raya']);
        Permission::create(['name' => 'manage pembayaran piutang']);
        Permission::create(['name' => 'manage penarikan dana']);
        Permission::create(['name' => 'view history simpanan pokok']);
        Permission::create(['name' => 'view history simpanan wajib']);
        Permission::create(['name' => 'view history simpanan hari raya']);
        Permission::create(['name' => 'view pembayaran piutang user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            'view dashboard',
            'manage users',
            'manage metadata angsuran',
            'manage pembayaran simpanan pokok',
            'manage pembayaran simpanan wajib',
            'manage pembayaran simpanan hari raya',
            'manage pembayaran piutang',
            'manage penarikan dana'
        ]);

        $userRole->givePermissionTo([
            'view dashboard',
            'view history simpanan pokok',
            'view history simpanan wajib',
            'view history simpanan hari raya',
            'view pembayaran piutang user'
        ]);
    }
}
