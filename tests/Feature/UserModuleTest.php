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
        $this->insertar_profesiones();

        $this->post('/usuarios/guardar',[
            'profession_id' => returnProfessionId(),
            'name' => 'oscar',
            'email' => 'oscar@gmail.com',
            'age' => 32,
            'password' => '123456',
            'twitter' => '',
            'bio' => ''
        ])->assertRedirect('/usuarios');
        
        $this->assertDatabaseHas('Users', [
            'name' => 'oscar',
            'email' => 'oscar@gmail.com',
            'age' => 32
        ]);
    }


    /** @test */
    public function formulario_nombre_requerido()
    {
        $this->insertar_profesiones();

        $this->from('usuarios/nuevo')
                ->post('/usuarios/guardar', [
                    'profession_id' => returnProfessionid(),
                    'name' => '',
                    'email' => 'oscar@gmail.com',
                    'age' => 32,
                    'password' => '1234'
                ])
                ->assertRedirect('/usuarios/nuevo')
                ->assertSessionHasErrors('name');

        $this->assertEquals(0, \App\Models\User::count());

        /* $this->assertDatabaseMissing('users', [
            'email' => 'oscar@gmail.com'
        ]); */
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
            ->post('/usuarios/guardar', [
                'profession_id' => 999,
                'name' => 'Oscar',
                'email' => 'oscar@gmail.com',
                'age' => 32,
                'password' => '1234'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('profession_id');

        $this->assertEquals(0, \App\Models\User::count());
    }


    /** @test */
    public function skills_deben_ser_un_array()
    {
        $this->insertar_profesiones();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios/guardar', [
                'profession_id' => returnProfessionid(),
                'name' => 'Oscar',
                'email' => 'oscar@gmail.com',
                'age' => 30,
                'password' => '1234',
                'skills' => 'PHP, JS'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('skills');

        $this->assertEquals(0, \App\Models\User::count());
    }


    /** @test */
    public function skills_deben_ser_validas()
    {
        $this->insertar_profesiones();

        $skillA = factory('App\Models\Skill')->create();
        $skillB = factory('App\Models\Skill')->create();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios/guardar', [
                'profession_id' => returnProfessionid(),
                'name' => 'Oscar',
                'email' => 'oscar@gmail.com',
                'age' => 30,
                'password' => '1234',
                'skills' => [$skillA->id, $skillB->id + 1]
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors('skills');
        
        $this->assertEquals(0, \App\Models\User::count());
    }

}
