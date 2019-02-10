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

        // Create permissions
        $permissions = [
            'create products',
            'edit products',
            'delete products',

            'edit any product',
            'delete any product',

            'create group orders',
            'edit group orders',
            'cancel group orders',

            'create orders',
            'edit orders',
            'cancel orders',

            'add items to cart',
            'remove items from cart',
            'edit cart contents',
        ];

        $this->createPermissions($permissions);

        // Create roles and assign created permissions

        // Seller
        try {
            $seller = Role::findByName('seller');
        } catch (Exception $e) {
            $seller = Role::create(['name' => 'seller']);
        }
        $seller_permissions = [
            'create products', 'edit products', 'delete products',
        ];
        $this->assignPermissions($seller, $seller_permissions);

        // Buyer
        try {
            $buyer = Role::findByName('buyer');
        } catch (Exception $e) {
            $buyer = Role::create(['name' => 'buyer']);
        }
        $buyer_permissions = [
                'create orders', 'edit orders', 'cancel orders',
                'add items to cart', 'remove items from cart', 'edit cart contents'
        ];
        $this->assignPermissions($buyer, $buyer_permissions);

        // Admin
        try {
            $admin = Role::findByName('admin');
        } catch (Exception $e) {
            $admin = Role::create(['name' => 'admin']);
        }
        $admin->givePermissionTo(Permission::all());
    }

    protected function createPermissions($permissions) {
        foreach ($permissions as $permission) {
            try {
                $a_permission = Permission::create(['name' => $permission]);
            } catch (Exception $e) {
                $a_permission = $permission;
            }
        }
    }

    protected function assignPermissions($role, $permissions) {
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }
    }
}