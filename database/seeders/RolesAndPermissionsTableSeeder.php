<?php

namespace Database\Seeders;

use App\Enums\CompanyRoleType;
use App\Enums\RoleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsTableSeeder extends Seeder
{
    protected $superadmin, $admin, $management, $employee;

    protected $superadminResources = [
        'users',
        'roles',
        'permissions',
        'dashboard',
    ];

    protected $employeeResources = [
        'dashboard',
    ];

    protected $actions = [
        'view',
        'create',
        'update',
        'delete',
    ];

    protected $readOnly = [
        'view',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->createRoles();
        $this->createPermissions();

        Schema::enableForeignKeyConstraints();
    }

    private function createRoles()
    {
        Role::truncate();
        Permission::truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->superadmin   = Role::create(['name' => RoleType::SUPER_ADMIN]);
        $this->admin        = Role::create(['name' => RoleType::ADMIN]);
        $this->management   = Role::create(['name' => RoleType::MANAGEMENT]);
        $this->employee     = Role::create(['name' => RoleType::EMPLOYEE]);
    }

    private function createPermissions()
    {
        collect($this->superadminResources)->each(function ($resource) {
            collect($this->actions)->each(function ($action) use ($resource) {
                Permission::firstOrCreate(['name' => "{$action} {$resource}"]);
                $this->superadmin->givePermissionTo("{$action} {$resource}");
                $this->admin->givePermissionTo("{$action} {$resource}");
            });
        });

        collect($this->employeeResources)->each(function ($resource) {
            collect($this->actions)->each(function ($action) use ($resource) {
                Permission::firstOrCreate(['name' => "{$action} {$resource}"]);
                $this->management->givePermissionTo("{$action} {$resource}");
                $this->employee->givePermissionTo("{$action} {$resource}");
            });
        });
    }
}
