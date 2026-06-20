@auth
    @include('include.barra', ['modo' => 'Subcategorias'])
    @can('categorySub')

        <head>
            <link href="{{ asset('css/estilos_notificacion.css') }}" rel="stylesheet" />
            <script src="{{ asset('js/notificaciones.js') }}" defer></script>
            <script src="{{ asset('js/tooltips.js') }}" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
        </head>
        <div class="bread_crumb">
            {{ Breadcrumbs::render('sub-category.index') }}
        </div>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-10-sm">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <button type="button" class="btn btn-light">
                                    <a href="{{ route('category.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l14 0" />
                                            <path d="M5 12l6 6" />
                                            <path d="M5 12l6 -6" />
                                        </svg>
                                    </a>
                                </button>
                                @if (count($subCategories) > 0)
                                    <h2>Subcategorías de {{ $subCategories[0]->categoryProduct->name }}</h2>
                                @endif

                                <span class="card-title">
                                    <a href="{{ route('categorySub.create') }}" type="button"
                                        class="btn btn-primary mx-2 float-right ">
                                        Crear Subcategoría
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table_container">
                                <div class="table-responsive">
                                    <table class="table table-striped w-100"
                                        id="example">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center">Nombre de la Subcategoría</th>
                                                <th class="text-center">Descripción</th>
                                                <th class="text-center">Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subCategories as $subCategory)
                                                <tr>

                                                    <td class="text-center">{{ $subCategory->name }}</td>
                                                    <td class="text-center">{{ $subCategory->description }}</td>
                                                    <td class="text-center">
                                                        @if ($subCategory->status == 1)
                                                            <p class="badge rounded-pill bg-success text-white fs-6">Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger fs-6">
                                                                Inactivo</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-success" tooltip="tooltip" title="Modificar"
                                                            href="{{ route('categorySub.edit', $subCategory->id) }}"><i
                                                                class="fa fa-fw fa-edit"></i></a>
                                                        <!-- Modal de Confirmacion -->
                                                        @if ($subCategory->status == true)
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Inactivar"
                                                                data-bs-target="#confirmationDestroy-{{ $subCategory->id }}"><i
                                                                    class="fa fa-fw fa-trash"></i></button>
                                                        @else
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Activar"
                                                                data-bs-target="#confirmationDestroy-{{ $subCategory->id }}"><i
                                                                    class="fa-solid fa-rotate"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                            <div class="contenedor-notificacion" id="contenedor-notificacion">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('sub-category.modal')
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
            <script>
                new DataTable('#example', {
                    responsive: true,
                    lengthChange: true,
                    paging: true,
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
