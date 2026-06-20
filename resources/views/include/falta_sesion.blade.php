@include('include.barra', ['modo'=>'Inicia sesión'])
<head>
    <link rel="stylesheet" href="{{ asset('css/accesos_directos.css') }}" type="text/css">
</head>
    <div class="div-endguest">
            <h1 class="title_cebolla">Sabias que...</h1>
            <img class="cebolla" src="{{ asset('img/cebolla.png')}}" alt="" />
            <br>
            <p>
                Masticar chicle mientras cortas una cebolla te ayudará a no llorar?, bueno pero eso no importa,
            </p>
            <p>
                lo que realmente nos importa es que:
            </p>
            <div type="button" class="boton_inicio_sesion">
                <a href="/login"><b>Inicies sesión.</b></a>
            </div>
    </div>
