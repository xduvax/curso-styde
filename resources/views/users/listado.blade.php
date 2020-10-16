
@extends('layout')

@section('titulo', 'Listado de usuarios')

@section('main')

    <h1> {{$titulo}} </h1>

    <div class='centrar'>
        <a class='btn btn-gris' href=" {{ url('/')}} ">Volver a inicio</a>
    </div>

    @if($users->isEmpty()) <!-- Usuarios es una instancia de la clase Collection, ergo puede utilizarse el metodo isEmpty -->

        <p>No hay usuarios registrados.</p>

    @else

        <table class='tabla-usuarios centrar'>
            <tr>
                <th>#</td>
                <th>Nombre</td>
                <th>Acciones</td>
            </tr>

            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><a href='{{ url("/usuarios/{$user->id}") }}'>{{$user->name}}</a></td>
                    <td class='td-especial'>
                        <a class='borde-icono' href='{{ url("/usuarios/{$user->id}") }}'> <img src="{{ asset('/img/view.png') }}"> </a>
                        <a class='borde-icono' href='{{ url("/usuarios/{$user->id}/editar") }}'> <img src="{{ asset('/img/edit.png') }}"> </a> 
                        <form method="POST" action='{{ url("/usuarios/{$user->id}/eliminar") }}'>
                            @csrf
                            @method('DELETE')
                            <button class='borde-icono' type='submit'> <img src="{{ asset('/img/delete.png') }}"> </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}

    @endif

@endsection
