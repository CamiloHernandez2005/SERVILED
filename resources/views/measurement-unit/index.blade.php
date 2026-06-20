@auth
    @can('units')
        @include('include.barra', ['modo' => 'Unidades de Medida'])

        <head>
            <link href="{{ asset('css/estilos_notificacion.css') }}" rel="stylesheet" />
            <script src="{{ asset('js/notificaciones.js') }}" defer></script>
            <script src="{{ asset('js/tooltips.js') }}" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
        </head>
        <br>

        <body>
            @livewireStyles
            @livewire('units-component');
            @livewireScripts
            {{-- Script  para mostrar la notificacion --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const mensajeFlash = {!! json_encode(Session::get('notificacion')) !!};
                    if (mensajeFlash) {
                        agregarnotificacion(mensajeFlash);
                    }
                });
            </script>
            <div class="contenedor-notificacion" id="contenedor-notificacion">
            </div>
            {{-- <script src="{{ asset('js/datatable.js') }}" defer></script> --}}
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
            <script>
                new DataTable('#datatable', {
                    responsive: true,
                    lengthChange: true,
                    // paging: false,
                    searching: true,
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "<<",
                            "sLast": ">>",
                            "sNext": ">",
                            "sPrevious": "<"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
            </script>
        </body>
    @else
        <div class="mensaje_Rol">
            <img src="{{ asset('img/Rol_no_asignado.png') }}" class="img_rol" />
            <h2 class="texto_noRol">Pídele al administrador que se te asigne un rol.</h2>
        </div>
    @endcan
@endauth
@guest
    @include('include.falta_sesion')
@endguest
