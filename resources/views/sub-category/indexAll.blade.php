@auth
    @can('categorySub')
        @include('include.barra', ['modo' => 'Subcategorías'])
        <script src="{{ asset('js/tooltips.js') }}" defer></script>
        <link href="css/estilos_notificacion.css" rel="stylesheet" />
        <script src="{{ asset('js/notificaciones.js') }}" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
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
                                <h2 id="card_title">
                                    {{ __('Todas Las Subcategorías') }}
                                </h2>
                                <button type="button" class="btn btn-warning mx-2 rounded" tooltip="tooltip" title="Importar"
                                    data-bs-toggle="modal" data-bs-target="#importSubcategories">
                                    <i class="fa-solid fa-folder-open text-dark"></i>
                                </button>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <div class="card-body">
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
                            <div class="table_container">
                                <div>
                                    <table class="table table-striped table-hover w-100" id="example">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Categoría</th>
                                                <th>Subcategoría</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subCategories as $subCategory)
                                                <tr>
                                                    <td>{{ $subCategory->categoryProduct->name }}</td>
                                                    <td>{{ $subCategory->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            @include('sub-category.modalImport')
        @else
            <div class="mensaje_Rol">
                <img src="{{ asset('img/Rol_no_asignado.png') }}" class="img_rol" />
                <h2 class="texto_noRol">Pídele al administrador que se te asigne un rol.</h2>
            </div>
        @endcan
    </div>
@endauth
@guest
    @include('include.falta_sesion')
@endguest
