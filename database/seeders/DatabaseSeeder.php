<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Mr.',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'SUPER_ADMIN',
            'password' => '$2y$10$wSscScjbnOcGfmHG3APs/urIWT0SwepWWwfM8fVW2OYJHQ2toUfxi',
            'gender' =>'MALE',
            'status' =>'ACTIVE',
        ]);
    }
}
