<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::updateOrCreate([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        $user = Role::updateOrCreate([
            'name' => 'User',
            'slug' => 'user',
        ]);
    }
}
