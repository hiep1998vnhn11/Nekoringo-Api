<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'show user']);
        Permission::create(['name' => 'create pub']);
        Permission::create(['name' => 'delete pub']);
        Permission::create(['name' => 'create comment']);
        Permission::create(['name' => 'delete comment']);
        Permission::create(['name' => 'create vote']);
        Permission::create(['name' => 'delete vote']);
        Permission::create(['name' => 'create dish']);
        Permission::create(['name' => 'delete dish']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'block user']);
        Permission::create(['name' => 'unblock user']);
        Permission::create(['name' => 'block comment']);
        Permission::create(['name' => 'unblock comment']);
        Permission::create(['name' => 'set admin']);
        Permission::create(['name' => 'unset admin']);

        $role1 = Role::create(['name' => 'viewer']);
        $role1->givePermissionTo('create comment');
        $role1->givePermissionTo('create pub');
        $role1->givePermissionTo('create vote');

        $role3 = Role::create(['name' => 'admin']);
        $role3->givePermissionTo(Permission::all());
        $admin = User::create([
            'email' => 'admin@nekoringo.vn',
            'password' => bcrypt('admin'),
            'name' => 'Admin'
        ]);
        $admin->assignRole($role3);

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        Role::create(['name' => 'blocked']);
        // Don't get any permission

    }
}
