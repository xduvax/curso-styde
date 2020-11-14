@extends('layout')

@section('titulo', 'Crear usuario')

@section('main')

    <h1> Crear nuevo usuario </h1>

    <div class='centrar'>
        <a class='btn btn-gris' href=" {{ url('/')}} ">Volver a inicio</a>
    </div>

    <div class='centrar'>
        <form class='form-usuarios' action="{{ url('usuarios/guardar') }}" method='POST'>
        @csrf

            <label for="name">Nombre</label>
            <input type="text" name='name' id='name' placeholder='Minimo 3 caracteres' value="{{ old('name') }}">
            @error('name')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="profession">Profesión</label>
            <select name="profession_id" id='profession'>
                <option value='' disabled selected>-Elige una profesion-</option>
                @foreach($professions as $profession)
                    <option value="{{$profession->id}}" {{ old('profession_id') == $profession->id ? ' selected' : '' }}>
                        {{ $profession->title }}
                    </option>
                @endforeach
            </select>
            @error('profession_id')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="age">Edad</label>
            <input type="text" name='age' id='age' placeholder='Numero' value="{{ old('age') }}">
            @error('age')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="email">Correo</label>
            <input type="email" name='email' id='email' placeholder='nombre@correo.com' value="{{ old('email') }}">
            @error('email')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="password">Password</label>
            <input type="password" name='password' id='password' placeholder='Minimo 4 caracteres'>
            @error('password')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="twitter">Twitter</label>
            <input type="text" name='twitter' id='twitter' placeholder='http://twitter.com/duva' value="{{ old('twitter') }}">
            @error('twitter')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="bio">Biografia</label>
            <textarea name="bio" id="bio">{{ old('bio') }}</textarea>
            @error('bio')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <p>Habilidades</p>
            @foreach($skills as $skill)
                <input type="checkbox" 
                    id="skill_{{ $skill->id }}" 
                    name="skills[{{ $skill->id }}]" 
                    value="{{ $skill->id }}"
                    {{ old("skills.{$skill->id}") ? 'checked' : '' }}
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
                    {{ old('role') == $role ? 'checked' : '' }}>
                <label class='inline' for="role_{{ $role }}">{{ $view }}</label>
            @endforeach
            @error('role')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <div class='centrar'> <input class='btn btn-azul' type="submit" value='Ingresar'> </div>

        </form>
    </div>

@endsection
