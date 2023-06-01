<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminRole = Role::findByName('admin');
        $bloggerRole = Role::findByName('blogger');
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ])->assignRole($adminRole);

        
        User::create([
            'name' => 'Natalie',
            'email' => 'natalie@natalie.com',
            'password' => bcrypt('password'),
        ])->assignRole($bloggerRole);

    }
}
