@auth
    @include('include.barra', ['modo' => 'Municipalities'])
    <br>
    <!DOCTYPE html>

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="css/estilos_vista_persona.css" rel="stylesheet" />
        <link href="css/estilos_notificacion.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">

    </head>
    <br>
    @can('municipalities')
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h2 id="card_title">
                                {{ Breadcrumbs::render('municipalities.index') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    {{-- Regresar atrás--}}
                                    <button type="button" class="btn btn-light">
                                        <a href="{{ route('index_informes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l14 0" />
                                                <path d="M5 12l6 6" />
                                                <path d="M5 12l6 -6" />
                                            </svg>
                                        </a>
                                    </button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <form action="{{ route('municipalities.index') }}" method="get" class="d-flex align-items-center js-dt-export">

                                        {{-- Botones IMPORTAR Y EXPORTAR --}}

                                        <button type="button" class="btn btn-success ms-2 rounded" tooltip="tooltip"
                                            title="Excel" onclick="window.location.href='{{ route('export.person') }}'">
                                            <i class="fa-solid fa-file-excel"></i>
                                        </button>

                                        <button type="button" class="btn btn-danger ms-2 rounded" tooltip="tooltip"
                                            title="PDF" onclick="window.location.href='{{ route('person.pdf') }}'">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- Script  para mostrar la notificacion --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const mensajeFlash = {!! json_encode(Session::get('notificacion')) !!};
                                if (mensajeFlash) {
                                    agregarnotificacion(mensajeFlash);
                                }
                            });
                        </script>
                        {{--  Div con las notificaciones nuevas  --}}
                        <div class="contenedor-notificacion" id="contenedor-notificacion">
                            {{--  Aqui trae las notificaciones por medio de javaescript  --}}
                        </div>
                        <div class="table_container p-3">
                            <div>
                                <table id="datatable" class="table table-striped table-hover w-100">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Codigo</th>
                                            <th class="text-center">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($municipalities as $municipality)
                                            <tr>
                                                <td class="text-center">{{ $municipality->id }}</td>
                                                <td class="text-center">{{ $municipality->name }}</td>
                                            </tr>
                                        @endforeach

                                        <script src="{{ asset('js/notificaciones.js') }}" defer></script>
                                        <script src="{{ asset('js/tooltips.js') }}" defer></script>
                                        <script src="{{ asset('js/datatable.js') }}" defer></script>
                                        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
                                        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
                                        <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
                                        <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  {{ !!$municipalities->links }}  --}}
            </div>
        </div>
    </div>
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
