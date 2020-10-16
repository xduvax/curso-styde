<?php

use Illuminate\Database\Seeder;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create([
            'title' => 'Desarrollador back-end'
        ]);

        Profession::create([
            'title' => 'Desarrollador front-end'
        ]);

        Profession::create([
            'title' => 'Diseñador web'
        ]);

        Profession::create([
            'title' => 'Administrador'
        ]);

        Profession::create([
            'title' => 'Enfermera'
        ]);
    }
}
