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

            <label for="nombre">Nombre</label>
            <input type="text" name='name' id='nombre' value="{{ old('name', $user->name) }}">
            @error('name')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="profesion">Profesión</label>
            <select name="profession_id" id="profesion">
                @foreach($professions as $profession)
                    <option value="{{$profession->id}}" @if($user->profession_id == $profession->id) {{'selected'}} @endif >{{ $profession->title }}</option>
                @endforeach
            </select>

            <label for="edad">Edad</label>
            <input type="text" name='age' id='edad' value="{{ old('age', $user->age) }}">
            @error('age')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="correo">Correo</label>
            <input type="email" name='email' id='correo' value="{{ old('email', $user->email) }}">
            @error('email')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <label for="clave">Password</label>
            <input type="password" name='password' id='clave' placeholder='Si mantiene el campo vacio no se cambiará la clave'>
            @error('password')
                <ul><li class='error-message'>{{ $message }}</li></ul>
            @enderror

            <div class='centrar'> <input class='btn btn-azul' type="submit" value='Actualizar'> </div>
        
        </form>
    </div>

@endsection