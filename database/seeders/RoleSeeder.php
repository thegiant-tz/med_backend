<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $stuffsRoles = Role::ROLES_NAME;
        foreach ($stuffsRoles as $key => $role) {
            Role::create([
                'name' => $role,
                'slug' => $key
            ]);
        }
    }
}
