<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();

        $superadmin = User::create([
            'name'      => RoleType::SUPER_ADMIN,
            'email'     => 'superadmin@admin.id',
            'username'  => 'superadmin@admin.id',
            'password'  => Hash::make('password'),
        ]);
        $superadmin->assignRole(RoleType::SUPER_ADMIN);

        $admin = User::create([
            'name'      => RoleType::ADMIN,
            'email'     => 'admin@admin.id',
            'username'  => 'admin@admin.id',
            'password'  => Hash::make('password'),
        ]);
        $admin->assignRole(RoleType::ADMIN);

        Schema::enableForeignKeyConstraints();
    }
}
