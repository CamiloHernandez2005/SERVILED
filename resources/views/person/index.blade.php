@auth


    @include('include.barra', ['modo' => 'Terceros'])

    <head>
        <title>Terceros</title>
        <link href="css/estilos_vista_persona.css" rel="stylesheet" />
        <link href="css/estilos_notificacion.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">


    </head>
    <br>
    @can('person')
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ Breadcrumbs::render('person.index') }}
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
                                            <a class="dropdown-item" href="{{ route('supplier.index') }}">Ver proveedores</a>
                                        </li>
                                    </ul>
                                </div>

                                <form action="{{ route('person.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                                    <input type="text" name="filtervalue" class="form-control" placeholder="Buscar tercero..." value="{{ request('filtervalue') }}">
                                    <button type="submit" class="btn btn-dark">Buscar</button>
                                </form>

                                <div class="ms-auto d-flex align-items-center gap-2">

                                    {{-- Botones IMPORTAR Y EXPORTAR --}}

                                    <button type="button" class="btn btn-success rounded" tooltip="tooltip"
                                        title="Excel" onclick="window.location.href='{{ route('export.person') }}'">
                                        <i class="fa-solid fa-file-excel"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger rounded" tooltip="tooltip"
                                        title="PDF" onclick="window.open('{{ route('person.pdf') }}','_blank')">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>

                                    <button type="button" class="btn btn-warning rounded" tooltip="tooltip"
                                        title="Importar" data-bs-toggle="modal" data-bs-target="#importPerson">
                                        <i class="fa-solid fa-folder-open"></i>
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
                            {{--  Aqui trae las notificaciones por medio de javaescript  --}}
                        </div>

                        <div class="container_datos p-3">
                            <div class="table_container">
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
                                            @foreach ($people as $person)
                                                <tr class="text-center">
                                                    <td>{{ $person->rol }}</td>
                                                    <td>{{ $person->identification_type }}</td>
                                                    <td>{{ $person->identification_number }}</td>
                                                    <td>{{ $person->digit_verification }}</td>
                                                    <td>{{ $person->company_name }}</td>
                                                    <td>{{ $person->first_name }}</td>
                                                    <td>{{ $person->other_name }}</td>
                                                    <td>{{ $person->surname }}</td>
                                                    <td>{{ $person->second_surname }}</td>
                                                    <td>{{ $person->comercial_name }}</td>
                                                    <td>{{ $person->email_address }}</td>
                                                    <td>{{ $person->municipality->name }}</td>
                                                    <td>{{ $person->address }}</td>
                                                    <td>{{ $person->phone }}</td>
                                                    <td>
                                                        @if ($person->status == true)
                                                            <p class="badge rounded-pill bg-success fs-6">
                                                                Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger fs-6">
                                                                Inactivo
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" tooltip="tooltip" title="Visualizar"
                                                            href="{{ route('person.show', $person->id) }}"><i
                                                                class="fa fa-fw fa-eye"></i>
                                                        </a>
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
                                        {{ $people->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @include('person.modal')
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

