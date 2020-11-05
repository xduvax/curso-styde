<?php

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::create([
            'name' => 'HTML'
        ]);

        Skill::create([
            'name' => 'CSS'
        ]);

        Skill::create([
            'name' => 'JS'
        ]);

        Skill::create([
            'name' => 'PHP'
        ]);

        Skill::create([
            'name' => 'TDD'
        ]);

        Skill::create([
            'name' => 'POO'
        ]);
    }
}
