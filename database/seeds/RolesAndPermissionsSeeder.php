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
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'edit any product']);
        Permission::create(['name' => 'delete any product']);

        Permission::create(['name' => 'create group orders']);
        Permission::create(['name' => 'edit group orders']);
        Permission::create(['name' => 'cancel group orders']);

        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'cancel orders']);

        Permission::create(['name' => 'add items to cart']);
        Permission::create(['name' => 'remove items from cart']);
        Permission::create(['name' => 'edit cart contents']);

        // create roles and assign created permissions
        $seller = Role::create(['name' => 'seller'])
            ->givePermissionTo([
                'create products', 'edit products', 'delete products',
            ]);

        $buyer = Role::create(['name' => 'buyer'])
            ->givePermissionTo([
                'create orders', 'edit orders', 'cancel orders',
                'add items to cart', 'remove items from cart', 'edit cart contents'
            ]);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}