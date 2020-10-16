<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Profession;
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
        return view('users.detalle', ['user' => $usuario]);
    }


    public function new()
    {
        $professions = Profession::all();

        return view('users.nuevo', ['professions' => $professions]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'profession_id' => ['exists:professions,id'],
            'age' => ['required', 'numeric', 'min:18'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4'],
            'bio' => 'required',
            'twitter' => ['nullable', 'url']
        ]);

        User::persistUser($data);

        return redirect('/usuarios');
    }


    public function edit(User $usuario)
    {
        return view('users.editar', [
            'user' => $usuario,
            'professions' => Profession::all()
        ]);
    }


    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'profession_id' => ['exists:professions,id'],
            'age' => ['required', 'integer'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ''
        ]);

        if($data['password'] != ''){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect("/usuarios/{$usuario->id}");
    }


    public function delete(User $usuario)
    {
        $usuario->delete();
        return redirect("/usuarios");
    }

}
