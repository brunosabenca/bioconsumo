<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);

        Permission::create(['name' => 'create group order']);
        Permission::create(['name' => 'edit group order']);
        Permission::create(['name' => 'cancel group order']);

        Permission::create(['name' => 'create order']);
        Permission::create(['name' => 'edit order']);
        Permission::create(['name' => 'cancel order']);

        Permission::create(['name' => 'add item to cart']);
        Permission::create(['name' => 'remove item from cart']);
        Permission::create(['name' => 'edit cart content']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'seller'])
            ->givePermissionTo([
                'create product', 'edit product', 'delete product',
            ]);
        $role = Role::create(['name' => 'buyer'])
            ->givePermissionTo([
                'create order', 'edit order', 'cancel order',
                'add item to cart', 'remove item from cart', 'edit cart content'
            ]);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}