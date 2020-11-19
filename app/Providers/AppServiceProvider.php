<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Profession;
use App\Models\Skill;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* View::composer(['users.nuevo', 'users.editar'], function($view) {

            $professions = Profession::orderBy('title', 'ASC')->get();
            $skills = Skill::orderBy('id', 'ASC')->get();
            $roles = ['admin' => 'Administrador', 'user' => 'Usuario'];

            $view->with([
                'professions' => $professions,
                'skills' => $skills,
                'roles' => $roles
            ]);

        }); */
    }

}
