@auth
@include('include.barra',['modo'=>'Ventas'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">   
    <link rel="stylesheet" href="{{ asset('css/estilosbarra.css') }}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/estilos_notificacion.css')}}" type="text/css">
    <script src="{{ asset('js/notificaciones.js')}}" defer></script>
    <script src="{{ asset('js/tooltips.js') }}" defer></script>
    @stack('css')

    <title>Ventas</title>
</head>
<body>
<main
    @yield('content')
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mensajeFlash = {!! json_encode(Session::get('notificacion')) !!};
        if (mensajeFlash) {
            agregarnotificacion(mensajeFlash);
        }
    });
</script>
<div class="contenedor-notificacion" id="contenedor-notificacion">
</div>
    @stack('js')
</body>
</html>

@endauth
@guest
    @include('include.falta_sesion')
@endguest
