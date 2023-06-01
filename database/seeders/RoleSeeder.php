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
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleBlogger = Role::create(['name' => 'blogger']);

        //syncRoles me permite asignarle los permisos a más de un rol, necesita un array
        Permission::create(['name' => 'admin.home'])->assignRole($roleAdmin);
        Permission::create(['name' => 'admin.create'])->assignRole($roleAdmin);
        Permission::create(['name' => 'admin.destroy '])->assignRole($roleAdmin);
        
        Permission::create(['name' => 'post.own'])->assignRole($roleBlogger);
        Permission::create(['name' => 'post.create'])->assignRole($roleBlogger);
        Permission::create(['name' => 'post.delete'])->assignRole($roleAdmin);


        $roleAdmin->syncPermissions(Permission::all());

    }
}
