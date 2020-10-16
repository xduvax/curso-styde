
@extends('layout')

@section('titulo', 'Perfil de usuario')

@section('main')

    <h1> Perfil de usuario #{{$user->id}} </h1>

    <div class='centrar'>
        <a class='btn btn-gris' href=" {{ url('/usuarios')}} ">Volver a listado</a>
    </div>

    <table class='tabla-usuarios centrar'>
    
        <tr>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Correo</th>
            <th>Profesion</th>
        </tr>

        <tr>
            <td> {{$user->name}} </td>
            <td> {{$user->age}} </td>
            <td> {{$user->email}} </td>
            <td> {{$user->profession->title}} </td>
        </tr>

    </table>

    <!-- <a class='boton-volver' href="{{ url()->previous() }}">Volver</a> -->

@endsection
