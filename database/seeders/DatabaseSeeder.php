<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        User::create([
            'noHp' => '081231',
            'nama' => 'PLAIN',
            'divisi' => 'Rumah tangga',
            'roles' => 'PLAIN',
            'password' => Hash::make('qwerty123')
        ]);
        User::create([
            'noHp' => '081232',
            'nama' => 'USER',
            'divisi' => 'Rumah tangga',
            'roles' => 'USER',
            'password' => Hash::make('qwerty123')
        ]);
        User::create([
            'noHp' => '081233',
            'nama' => 'ADMIN',
            'divisi' => 'Rumah tangga',
            'roles' => 'ADMIN',
            'password' => Hash::make('qwerty123')
        ]);
    }
}
