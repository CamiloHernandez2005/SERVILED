@auth
    @can('supplier')
        @include('include.barra', ['modo' => 'SERVILED'])

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
                                {{ Breadcrumbs::render('supplier.index') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                {{-- Desplegable de opciones --}}
                                <div class="dropdown">
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">Acciones</button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('person.create') }}">Crear tercero</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('customer.index') }}">Ver clientes</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('person.index')}}">Ver tabla general de terceros</a>
                                            </li>
                                        </ul>
                                </div>

                                {{-- Buscador --}}
                                <form action="{{ route('supplier.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                                    <input type="text" name="filtervalue" class="form-control" placeholder="Buscar proveedor..." value="{{ request('filtervalue') }}">
                                    <button type="submit" class="btn btn-dark">Buscar</button>
                                </form>

                                {{-- Botones EXPORTAR --}}
                                <div class="ms-auto d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-success rounded" tooltip="tooltip"
                                        title="Excel" onclick="window.location.href='{{ route('export.supplier') }}'">
                                        <i class="fa-solid fa-file-excel"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger rounded" tooltip="tooltip"
                                        title="PDF" onclick="window.open('{{ route('supplier.pdf') }}','_blank')">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>
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

                        <div class="container_datos">
                            <div class="table_container p-3">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="datatable">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th>Tercero</th>
                                                <th>Tipo ID</th>
                                                <th>Identificación</th>
                                                <th>DV</th>
                                                <th>Razón social</th>
                                                <th>Primer nombre</th>
                                                <th>Otro nombre</th>
                                                <th>Apellido</th>
                                                <th>Segundo apellido</th>
                                                <th>Nombre comercial</th>
                                                <th>Correo electrónico</th>
                                                <th>Ciudad</th>
                                                <th>Dirección</th>
                                                <th>Celular</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($proveedores as $proveedor)
                                                <tr class="text-center">
                                                    <td >{{ $proveedor->rol }}</td>
                                                    <td>{{ $proveedor->identification_type }}</td>
                                                    <td>{{ $proveedor->identification_number }}</td>
                                                    <td>{{ $proveedor->digit_verification }}</td>
                                                    <td>{{ $proveedor->company_name }}</td>
                                                    <td>{{ $proveedor->first_name }}</td>
                                                    <td>{{ $proveedor->other_name }}</td>
                                                    <td>{{ $proveedor->surname }}</td>
                                                    <td>{{ $proveedor->second_surname }}</td>
                                                    <td>{{ $proveedor->comercial_name }}</td>
                                                    <td>{{ $proveedor->email_address }}</td>
                                                    <td>{{ $proveedor->municipality->name }}</td>
                                                    <td>{{ $proveedor->address }}</td>
                                                    <td>{{ $proveedor->phone }}</td>
                                                    <td>
                                                        @if ($proveedor->status == true)
                                                            <p class="badge rounded-pill bg-success fs-6">
                                                                Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger fs-6">
                                                                Inactivo</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" tooltip="tooltip" title="Visualizar"
                                                            href="{{ route('supplier.show', $proveedor->id) }}"><i
                                                                class="fa fa-fw fa-eye"></i></a>
                                                        <a class="btn btn-sm btn-success" tooltip="tooltip" title="Modificar"
                                                            href="{{ route('supplier.edit', $proveedor->id) }}"><i
                                                                class="fa fa-fw fa-edit"></i></a>

                                                        {{--  <!-- Button trigger modal -->  --}}

                                                        @if ($proveedor->status == true)
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip"
                                                                title="Inactivar"
                                                                data-bs-target="#confirmationDestroy-{{ $proveedor->id }}"><i
                                                                    class="fa fa-fw fa-trash"></i></button>
                                                        @else
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Activar"
                                                                data-bs-target="#confirmationDestroy-{{ $proveedor->id }}"><i
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
                                    <div class="mt-3 d-flex justify-content-center">
                                        {{ $proveedores->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        @include('supplier.modal')
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
