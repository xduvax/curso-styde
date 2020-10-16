<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModuleTest extends TestCase
{
    use RefreshDataBase;

    /** @test */
    public function vista_nuevo_usuario_tiene_variable_profesiones()
    {
        $this->withoutExceptionHandling();

        $profesion = factory('App\Models\Profession')->create();

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertViewHas('professions', function($profesiones) use ($profesion){
                return $profesiones->contains($profesion);
            });
    }
}
