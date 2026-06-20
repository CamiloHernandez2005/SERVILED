@auth
    @include('include.barra', ['modo'=>'Usuarios'])
    @can('admin.usuarios.index')
    <head>
        <link href="css/estilos_notificacion.css" rel="stylesheet"/>
        <script src="{{ asset('js/notificaciones.js')}}" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    </head>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ Breadcrumbs::render('admin.index') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        </div>

                        <div class="table_container">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="datatable">
                                    <thead class="table-dark">
                                        <tr class="text-center">
                                            <th>Nombre</th>
                                            <th>Correo electronico</th>
                                            <th>Numero de celular</th>
                                            <th>Tipo de documento</th>
                                            <th>Numero de identificacion</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $usuarios as $usuario )
                                        <tr class="text-center">
                                            {{-- Aquí se traen los datos guardados de los usuarios --}}
                                            <td>{{$usuario->name }}</td>
                                            <td>{{$usuario->email }}</td>
                                            <td>{{$usuario->phone_number }}</td>
                                            <td>{{$usuario->document_type }}</td>
                                            <td>{{$usuario->identification_number }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="{{route('admin.usuarios.edit', $usuario->id)}}">Accesos <i class="fa-solid fa-people-line"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                        <script src="{{ asset('js/datatable.js') }}" defer></script>
                                        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
                                        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
                                        <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
                                        <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Script para mostrar la notificación --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const mensajeFlash = {!! json_encode(Session::get('notificacion')) !!};
                            if (mensajeFlash) {
                                agregarnotificacion(mensajeFlash);
                            }
                        });
                    </script>

                    {{-- Div con las notificaciones nuevas --}}
                    <div class="contenedor-notificacion" id="contenedor-notificacion">
                        {{-- Aquí trae las notificaciones por medio de JavaScript --}}
                    </div>
                    <div class="container_datos">
                        {{-- Validación para cuando se busca una información y no se encuentra --}}
                        @if($usuarios->count())

                        @else
                        <div class="card-body">
                            <strong>No hay registros</strong>
                        </div>
                        @endif
                    </div>
                </div>
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
