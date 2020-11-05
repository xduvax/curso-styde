<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Profession;
use App\Models\Skill;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function list()
    {
        $users = User::paginate(10);

        return view('users.listado', [
            'users' => $users,
            'titulo' => 'Listado de usuarios'
        ]);
    }


    public function detail(User $usuario)
    {
        $profile = UserProfile::where('user_id', $usuario->id)->first();

        return view('users.detalle', [
            'user' => $usuario,
            'profile' => $profile
        ]);
    }


    public function new()
    {
        $professions = Profession::orderBy('title', 'ASC')->get();
        $skills = Skill::orderBy('id', 'ASC')->get();

        $roles = [
            'admin' => 'Administrador',
            'user' => 'Usuario'
        ];

        return view('users.nuevo', [
            'professions' => $professions,
            'skills' => $skills,
            'roles' => $roles,
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', 'string'],
            'profession_id' => ['required', 'exists:professions,id'], //Rule::exists('professions', 'id')->where('selectable', true)
            'age' => ['required', 'numeric'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4'],
            'twitter' => ['nullable', 'present', 'url'],
            'bio' => ['nullable', 'present'],
            'skills' => [
                'array',
                Rule::exists('skills', 'id'),
            ],
            'role' => ['nullable', Rule::in('admin', 'user')]
        ]);

        User::persistUser($data);

        return redirect('/usuarios');
    }


    public function edit(User $usuario)
    {
        $profile = UserProfile::where('user_id', $usuario->id)->first();

        return view('users.editar', [
            'user' => $usuario,
            'professions' => Profession::all(),
            'profile' => $profile
        ]);
    }


    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'profession_id' => ['required', 'exists:professions,id'],
            'age' => ['required', 'integer'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => '',
            'twitter' => ['nullable', 'url'],
            'bio' => ['present']
        ]);

        if($data['password'] != ''){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $user_profile = UserProfile::where('user_id', $usuario->id)->first();
        
        DB::transaction(function() use ($usuario, $user_profile, $data){
            $user_profile->update($data);
            $usuario->update($data);
        });

        return redirect("/usuarios/{$usuario->id}");
    }


    public function delete(User $usuario)
    {
        $user_profile = UserProfile::where('user_id', $usuario->id)->first();
        
        if($user_profile != null){
            DB::transaction(function() use($usuario, $user_profile){
                $user_profile->delete();
                $usuario->delete();
            });
        }else{
            $usuario->delete();
        }

        return redirect("/usuarios");
    }

}
