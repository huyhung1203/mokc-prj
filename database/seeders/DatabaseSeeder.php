<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
use Database\Factories\CheckInFactory;
use Database\Factories\MemberFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $permission[] = Permission::create(['name' => 'view members']);
        $permission[] = Permission::create(['name' => 'create members']);
        $permission[] = Permission::create(['name' => 'edit members']);
        $permission[] = Permission::create(['name' => 'delete members']);
        $permission[] = Permission::create(['name' => 'view staff']);
        $permission[] = Permission::create(['name' => 'create staff']);
        $permission[] = Permission::create(['name' => 'edit staff']);
        $permission[] = Permission::create(['name' => 'delete staff']);
        $permission[] = Permission::create(['name' => 'view check ins']);
        $permission[] = Permission::create(['name' => 'create check ins']);
        $permission[] = Permission::create(['name' => 'view statistics']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo($permission);
        $roleStaff = Role::create(['name' => 'staff']);
        $roleStaff->givePermissionTo([
            'view members',
            'create members',
            'edit members',
            'delete members',
            'create check ins',
        ]);
        $admin = User::create([
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number'=>'0123456789',
            'password' => bcrypt('admin@123'),
            'dob' => '2000-01-01',
            'level' => 0,
        ]);
        $admin->assignRole('admin');
        $staff = User::create([
            'full_name' => 'staff',
            'email' => 'staff@gmail.com',
            'phone_number'=>'0123456789',
            'password' => bcrypt('staff@123'),
            'dob' => '2000-01-01',
            'level' => 1,
        ]);
        $staff->assignRole('staff');
        
        $expired_date = Carbon::tomorrow()->toDateString();
        \App\Models\Member::factory(MemberFactory::class)->count(250)->create();
        \App\Models\Member::factory(MemberFactory::class)->count(250)->create(['code' => null, 'is_gues' => 1, 'ended_date' => $expired_date]);
        \App\Models\CheckIn::factory(CheckInFactory::class)->count(500)->create();
    }
}
