<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'africa.jatakalula',
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','name')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
