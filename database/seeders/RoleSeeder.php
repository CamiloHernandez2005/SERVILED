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
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Trabajador']);

        //Permisos para la vista de usuarios -> Administrador
        Permission::create(['name' => 'admin.usuarios.index'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios.edit'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios.update'])->assignRole($role1);
        Permission::create(['name' => '/backup'])->assignRole($role1);

        //Permisos para las vistas del proyecto -> Administrador y Trabajador
        Permission::create(['name' => 'home'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'products'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'category'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'brand'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'units'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'categorySub'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'credit-note-sales'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'person'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'customer'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'supplier'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'indexAll'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'purchase_supplier'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'detail-purchases'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'debit-note-supplier'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'report'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'profile'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'reports'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Product_movement'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Historial_precios_compra'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Historial_productos'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'municipalities'])->syncRoles([$role1,$role2]);
    }
}
