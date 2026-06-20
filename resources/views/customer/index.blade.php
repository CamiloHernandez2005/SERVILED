@auth
    @can('customer')
        @include('include.barra', ['modo' => 'Clientes'])

        <head>
            <link href="css/estilos_vista_persona.css" rel="stylesheet" />
            <link href="css/estilos_notificacion.css" rel="stylesheet" />
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
                                {{ Breadcrumbs::render('customer.index') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{--  Desplegable de opciones  --}}

                                    <div class="dropdown">
                                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">Acciones</button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('person.create') }}">Crear Tercero</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('supplier.index') }}">Ver proveedores</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('person.index')}}">Ver tabla general de terceros</a>
                                                </li>
                                            </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <form action="{{ route('customer.index') }}" method="get"
                                        class="d-flex align-items-center js-dt-export justify-content-end">

                                        {{-- Botones EXPORTAR --}}

                                        <button type="button" class="btn btn-success ms-2 rounded" data-bs-toggle="tooltip"
                                            title="Excel" onclick="window.location.href='{{ route('export.customer') }}'">
                                            <i class="fa-solid fa-file-excel"></i>
                                        </button>

                                        <button type="button" class="btn btn-danger ms-2 rounded" tooltip="tooltip"
                                            title="PDF" onclick="window.open('{{ route('customer.pdf') }}','_blank')">
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
                            {{--  Aqui trae las notificaciones por medio de javascript  --}}
                        </div>

                        <div class="container_datos p-3">
                            <div class="table_container">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="datatable">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th>Tercero</th>
                                                <th>Tipo ID</th>
                                                <th>Identificacion</th>
                                                <th>DV</th>

                                                <th>Razon social</th>
                                                <th>Primer nombre</th>
                                                <th>Otro nombre</th>
                                                <th>Apellido</th>
                                                <th>Segundo apellido</th>
                                                <th>Nombre comercial</th>
                                                <th>Correo electronico</th>
                                                <th>Ciudad</th>
                                                <th>Direccion</th>
                                                <th>Celular</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clientes as $cliente)
                                                <tr class="text-center">
                                                    <td>{{ $cliente->rol }}</td>
                                                    <td>{{ $cliente->identification_type }}</td>
                                                    <td>{{ $cliente->identification_number }}</td>
                                                    <td>{{ $cliente->digit_verification }}</td>
                                                    <td>{{ $cliente->company_name }}</td>
                                                    <td>{{ $cliente->first_name }}</td>
                                                    <td>{{ $cliente->other_name }}</td>
                                                    <td>{{ $cliente->surname }}</td>
                                                    <td>{{ $cliente->second_surname }}</td>
                                                    <td>{{ $cliente->comercial_name }}</td>
                                                    <td>{{ $cliente->email_address }}</td>
                                                    <td>{{ $cliente->municipality->name }}</td>
                                                    <td>{{ $cliente->address }}</td>
                                                    <td>{{ $cliente->phone }}</td>
                                                    <td>
                                                        @if ($cliente->status == true)
                                                            <p class="badge rounded-pill bg-success fs-6">
                                                                Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger fs-6">
                                                                Inactivo</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" tooltip="tooltip" title="Visualizar"
                                                            href="{{ route('customer.show', $cliente->id) }}"><i
                                                                class="fa fa-fw fa-eye"></i></a>
                                                        <a class="btn btn-sm btn-success" tooltip="tooltip" title="Modificar"
                                                            href="{{ route('customer.edit', $cliente->id) }}"><i
                                                                class="fa fa-fw fa-edit"></i></a>

                                                        {{--  <!-- Button trigger modal -->  --}}

                                                        @if ($cliente->status == true)
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Inactivar"
                                                                data-bs-target="#confirmationDestroy-{{ $cliente->id }}"><i
                                                                    class="fa fa-fw fa-trash"></i></button>
                                                        @else
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Activar"
                                                                data-bs-target="#confirmationDestroy-{{ $cliente->id }}"><i
                                                                    class="fa-solid fa-rotate"></i></button>
                                                        @endif
                                                    </td>
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
                </div>
                {{--  {!! $people->links() !!}  --}}
            </div>

        @include('customer.modal')
        @else
    <div class="mensaje_Rol">
        <img src="{{ asset('img/Rol_no_asignado.png')}}" class="img_rol"/>
        <h2 class="texto_noRol">Pídele al administrador que se te asigne un rol.</h2>
    </div>
    @endcan
    @endauth
    @guest
        @include('include.falta_sesion')
    @endguest
