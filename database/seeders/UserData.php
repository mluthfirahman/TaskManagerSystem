<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'luthfi.rahman',
                'email' => 'luthfirahh@gmail.com',
                'id_role' => 1,
                'password' => 'admin1',
            ],
            [
                'username' => 'muhammad.luthfi',
                'email' => 'mluthfi@gmail.com',
                'id_role' => 2,
                'password' => '123456',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
