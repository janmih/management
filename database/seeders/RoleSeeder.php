<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(RoleEnum::cases() as $roles){
            Role::create([
                'name' => $roles->value
            ]);
        }
        (Permission::create([
            'name' => 'services.*'
        ]))->assignRole(
            Role::firstWHere('name', RoleEnum::RH->value)
        );
        (Permission::create([
            'name' => 'personnels.*'
        ]))->assignRole(
            Role::firstWHere('name', RoleEnum::RH->value)
        );
        (Permission::create([
            'name' => 'conge.*'
        ]))->assignRole(
            Role::firstWHere('name', RoleEnum::RH->value)
        );
        (Permission::create([
            'name' => 'repos-medical.*'
        ]))->assignRole(
            Role::firstWHere('name', RoleEnum::RH->value)
        );
        (Permission::create([
            'name' => 'mission.*'
        ]))->assignRole(
            Role::firstWHere('name', RoleEnum::RH->value)
        );
        (Permission::create([
            'name' => 'authorisation-absence.*'
        ]))->assignRole(
            Role::firstWHere('name', RoleEnum::RH->value)
        );
    }
}
