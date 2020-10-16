<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('titulo', 'Curso Styde') </title>

    <link rel="stylesheet" href=" {{ asset('css/app.css') }} ">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

</head>
<body>

    <header>
        <ul>
            <li class="{{ url()->current() == url('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">Inicio</a>
            </li>
            <li class="{{ url()->current() == url('/usuarios') ? 'active' : '' }}">
                <a href="{{ url('/usuarios') }}">Usuarios</a>
            </li>
            <li class="{{ url()->current() == url('/usuarios/nuevo') ? 'active' : '' }}">
                <a href="{{ url('/usuarios/nuevo') }}">Crear usuario</a>
            </li>
        </ul>
    </header>

    <main class="main-principal">
        @yield('main')
    </main>
    
</body>
</html>
