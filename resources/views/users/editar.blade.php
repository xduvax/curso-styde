@extends('layout')

@section('titulo', 'Editar usuario')

@section('main')

    <h1> Editar usuario </h1>
    
    <div class='centrar'>
        <a class='btn btn-gris' href=" {{ url('/usuarios')}} ">Volver a usuarios</a>
    </div>

    <div class='centrar'>
        <form class='form-usuarios' action='{{ url("usuarios/{$user->id}") }}' method='POST'>
        @csrf
        @method('PUT')

            <label for="name">Nombre</label>
            <input type="text" name='name' id='name' value="{{ old('name', $user->name) }}">
            @error('name')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="profession">Profesión</label>
            <select name="profession_id" id="profession">
                @foreach($professions as $profession)
                    <option value="{{$profession->id}}"
                        @if($user->profession_id == $profession->id) 
                            {{'selected'}} 
                        @endif >
                        {{ $profession->title }}
                    </option>
                @endforeach
            </select>

            <label for="age">Edad</label>
            <input type="text" name='age' id='age' value="{{ old('age', $user->age) }}">
            @error('age')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="email">Correo</label>
            <input type="email" name='email' id='email' value="{{ old('email', $user->email) }}">
            @error('email')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="password">Password</label>
            <input type="password" name='password' id='password' placeholder='Si mantiene el campo vacio no se cambiará la clave'>
            @error('password')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="twitter">Twitter</label>
            <input type="text" name='twitter' id='twitter' placeholder='http://twitter.com/duva' value="{{ old('twitter', $user->profile->twitter) }}">
            @error('twitter')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="bio">Biografia</label>
            <textarea name="bio" id="bio">{{ old('bio', $user->profile->bio) }}</textarea>
            @error('bio')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <p>Habilidades</p>
            @foreach($skills as $skill)
                <input type="checkbox" 
                    id="skill_{{ $skill->id }}" 
                    name="skills[{{ $skill->id }}]" 
                    value="{{ $skill->id }}"
                    {{ ( $errors->any() ? old("skills.{$skill->id}") : $user->skills->contains($skill) ) ? 'checked' : '' }}
                    >
                <label class='inline' for="skill_{{ $skill->id }}">{{$skill->name}}</label>
            @endforeach
            @error('skills')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <p>Rol</p>
            @foreach($roles as $role => $view)
                <input type="radio" 
                    id="role_{{ $role }}" 
                    name="role" 
                    value="{{ $role }}"
                    {{ old('role', $user->role) == $role ? 'checked' : '' }}>
                <label class='inline' for="role_{{ $role }}">{{ $view }}</label>
            @endforeach
            @error('role')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <div class='centrar'> <input class='btn btn-azul' type="submit" value='Actualizar'> </div>
        
        </form>
    </div>

@endsection
