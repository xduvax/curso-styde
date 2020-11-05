<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profession;
use App\Models\User;

class UserModuleTest extends TestCase
{
    use RefreshDatabase;

    private function insertar_profesiones()
    {
        return factory('App\Models\Profession', 5)->create();
    }


    public function getValidData(array $custom = [])
    {
        $this->insertar_profesiones();

        return array_merge([
            'profession_id' => returnProfessionId(),
            'name' => 'Oscar Diaz',
            'email' => 'oscar@gmail.com',
            'age' => 30,
            'password' => '1234',
            'twitter' => 'https://twitter.com/xduvax',
            'bio' => 'Programador back-end',
            'role' => 'user'
        ], $custom);
    }


    /** @test */
    public function pantalla_inicio_imagen_dark()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('<img src="http://laravel-6.test/img/dark2.jpg">');
    }


    /** @test */
    public function pantalla_listado_usuarios_vacio()
    {
        $this->get('/usuarios')
            ->assertSee('No hay usuarios registrados.');
    }


    /** @test */
    public function cantidad_usuarios()
    {
        $this->insertar_profesiones();

        factory('App\Models\User', 10)->create();
        $this->assertEquals(10, \App\Models\User::count());
    }


    /** @test */
    public function pantalla_listado_usuarios()
    {
        $this->insertar_profesiones();

        factory('App\Models\User')->create([
            'name' => 'Oscar Diaz'
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Oscar Diaz');
    }


    /** @test */
    public function pantalla_usuario_nuevo()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }


    /** @test */
    public function creacion_usuario()
    {
        $skillA = factory('App\Models\Skill')->create();
        $skillB = factory('App\Models\Skill')->create();

        $this->post('/usuarios/guardar', $this->getValidData([
            'skills' => [$skillA->id, $skillB->id]
        ]))
        ->assertRedirect('/usuarios');
        
        $usuario = User::where('email','oscar@gmail.com')->first();
        
        $this->assertDatabaseHas('users', [
            'name' => 'Oscar Diaz',
            'email' => 'oscar@gmail.com',
            'age' => 30,
            'role' => 'user'
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'twitter' => 'https://twitter.com/xduvax',
            'bio' => 'Programador back-end',
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $usuario->id,
            'skill_id' => $skillA->id
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $usuario->id,
            'skill_id' => $skillB->id
        ]);
    }


    /** @test */
    public function formulario_nombre_requerido()
    {
        $this->insertar_profesiones();

        $this->from('usuarios/nuevo')
                ->post('/usuarios/guardar', $this->getValidData([
                    'name' => ''
                ]))
                ->assertRedirect('/usuarios/nuevo')
                ->assertSessionHasErrors('name');

        //$this->assertEquals(0, \App\Models\User::count());

        $this->assertDatabaseMissing('users', [
            'email' => 'oscar@gmail.com'
        ]);
    }


    /** @test */
    public function error_404_si_no_existe_usuario()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Not Found');
    }


    /** @test */
    public function vista_nuevo_usuario_tiene_variable_profesiones()
    {
        $this->insertar_profesiones();

        $profesion = factory('App\Models\Profession')->create();

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertViewHas('professions', function($profesiones) use ($profesion){
                return $profesiones->contains($profesion);
            });
    }


    /** @test */
    public function profesion_debe_ser_valida()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/guardar', $this->getValidData([
                'profession_id' => 999
            ]))
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('profession_id');

        $this->assertDatabaseMissing('users', [
            'email' => 'oscar@gmail.com'
        ]);
        $this->assertEquals(0, \App\Models\User::count());
    }


    /** @test */
    public function skills_deben_ser_un_array()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/guardar', $this->getValidData([
                'skills' => 'PHP, JS'
            ]))
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('skills');

        $this->assertEquals(0, \App\Models\User::count());
    }


    /** @test */
    public function skills_deben_ser_validas()
    {
        $skillA = factory('App\Models\Skill')->create();
        $skillB = factory('App\Models\Skill')->create();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios/guardar', $this->getValidData([
                'skills' => [$skillA->id, $skillB->id + 1]
            ]))
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('skills');
        
        $this->assertEquals(0, \App\Models\User::count());
    }


    /** @test */
    public function campo_role_es_opcional()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/guardar', $this->getValidData([
                'role' => null
            ]))
            ->assertRedirect('/usuarios');

        $this->assertDatabaseHas('users', [
            'email' => 'oscar@gmail.com',
            'role' => 'user'
        ]);
    }


    /** @test */
    public function role_debe_ser_valido()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/guardar', $this->getValidData([
                'role' => 'rol-invalido'
            ]))
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('role');

        $this->assertEquals(0, \App\Models\User::count());
    }


    /** @test */
    public function eliminar_usuario()
    {
        $this->insertar_profesiones();
        $usuario = factory('App\Models\User')->create();

        $this->delete("/usuarios/{$usuario->id}")
            ->assertRedirect('/usuarios');

        $this->assertDatabaseMissing('users', [
           'id' => $usuario->id
        ]);
    }

}
