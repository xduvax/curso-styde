<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* User::create([
            'profession_id' => '1',
            'name' => 'Oscar Diaz',
            'age' => 32,
            'email' => 'oscar@gmail.com',
            'password' => bcrypt('1234')
        ]);

        User::create([
            'profession_id' => '5',
            'name' => 'Ana Luisa',
            'age' => 23,
            'email' => 'ana@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        factory(User::class,5)->create(); */
    }
}
