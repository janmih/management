<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        User::factory()->create([
            'role' => RoleEnum::RH->value
        ])->assignRole(Role::firstWHere('name', RoleEnum::RH->value));
        User::factory()->create([
            'name' => "Iloniaina",
            'email' => "ilocacsu@gmail.com",
            'role' => 'Super Admin'
        ])->assignRole(Role::firstWHere('name', RoleEnum::SUPER_ADMIN->value));
        User::factory()->create([
            'role' => 'DC'
        ])->assignRole(Role::firstWHere('name', RoleEnum::DC->value));
        User::factory()->create([
            'role' => 'SSE'
        ])->assignRole(Role::firstWHere('name', RoleEnum::SSE->value));
        User::factory()->create([
            'role' => 'SPSS'
        ])->assignRole(Role::firstWHere('name', RoleEnum::SPSS->value));
        User::factory()->create([
            'role' => 'SMF'
        ])->assignRole(Role::firstWHere('name', RoleEnum::SMF->value));
        User::factory()->create([
            'role' => RoleEnum::SMF->value
        ])->assignRole(Role::firstWHere('name', RoleEnum::CHEFFERIE->value));
        User::factory(15)->create([
            'role' => 'User'
        ])->each(fn(User $user) => $user->assignRole(Role::firstWHere('name', RoleEnum::USER->value)));

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
