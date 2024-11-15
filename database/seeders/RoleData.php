<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // data role
        $role = [
            [
                'nama' => 'Administrasion',
            ],
            [
                'nama' => 'Staff',
            ]
        ];
        Role::insert($role);
    }
}
