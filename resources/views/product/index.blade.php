@auth
    @include('include.barra', ['modo' => 'Productos'])
    <br>

    <head>
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="{{ asset('css/products/all.css') }}" rel="stylesheet" />
        <link href="css/estilos_notificacion.css" rel="stylesheet" />
        <script src="{{ asset('js/notificaciones.js') }}" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
        <script src="{{ asset('js/tooltips.js') }}" defer></script>
    </head>
    @can('products')
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h2 id="card_title">
                                {{--  {{ __('Productos') }}  --}}
                                {{ Breadcrumbs::render('products') }}
                            </h2>

                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">Acciones
                                        <span class="visually-hidden">Nuevo</span>
                                    </button>
                                    <ul class="dropdown-menu desplegable_acciones">
                                        <div class="acciones_boton">
                                            <li><a class="dropdown-item" href="{{ route('brand.index') }}">Crear Marca</a></li>
                                            <li><a class="dropdown-item" href="{{ route('products.create') }}">Crear
                                                    Producto</a></li>
                                        </div>
                                    </ul>
                                </div>

                                <form action="{{ route('products.index') }}" method="get"
                                    class="ms-auto d-flex align-items-center gap-2 mb-0">
                                    <input name="filtervalue" type="text" class="form-control"
                                        placeholder="Buscar Producto...." value="{{ request('filtervalue') }}">
                                    <button type="submit" class="btn btn-dark">Buscar</button>
                                    <a type="button" class="btn btn-success rounded" tooltip="tooltip"
                                        title="Excel" href="{{ route('export') }}">
                                        <i class="fa-solid fa-file-excel"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger rounded" tooltip="tooltip"
                                        title="PDF" onclick="window.open('{{ route('products.pdf') }}','_blank')">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning rounded" tooltip="tooltip"
                                        title="Importar" data-bs-toggle="modal" data-bs-target="#importProducts">
                                        <i class="fa-solid fa-folder-open text-dark"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="table_container">
                                <div>
                                    <table class="table table-striped table-hover w-100" id="example">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Referencia Fabrica</th>
                                                <th class="text-center">Clasificación Tributaria</th>
                                                <th class="text-center">Precio de Compra</th>
                                                <th class="text-center">Precio de Venta sin IVA</th>
                                                <th class="text-center">Marca</th>
                                                <th class="text-center">Unidad de Medida</th>
                                                <th class="text-center">Existencias</th>
                                                <th class="text-center">Foto</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productos as $producto)
                                                <tr>
                                                    <td class="text-center">{{ $producto->name_product }}</td>
                                                    <td class="text-center">{{ $producto->factory_reference }}</td>
                                                    <td class="text-center">{{ $producto->classification_tax }}</td>
                                                    <td class="text-center">
                                                        ${{ number_format($producto->purchase_price, 0, ',', '.') }}</td>
                                                    <td class="text-center">
                                                        ${{ number_format($producto->selling_price, 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ $producto->brand?->name ?? '-' }}</td>
                                                    <td class="text-center">{{ $producto->measurementUnit?->name ?? '-' }}</td>
                                                    <td class="text-center">
                                                        @if ($producto->stock < 5)
                                                            <span class="badge rounded-pill bg-danger fs-6"
                                                                tooltip="tooltip"
                                                                title="Pocas Existencias">{{ $producto->stock }}</span>
                                                        @else
                                                            <span>{{ $producto->stock }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($producto->photo)
                                                            <img src="{{ asset('storage/' . $producto->photo) }}"
                                                                width="80" height="80">
                                                        @else
                                                            <img src="{{ asset('img/products/default.webp') }}"
                                                                width="80" height="80">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($producto->status == 1)
                                                            <p class="badge rounded-pill bg-success text-white fs-6">Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger fs-6">
                                                                Inactivo</p>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-primary " tooltip="tooltip"
                                                            title="Visualizar"
                                                            href="{{ route('products.show', $producto->id) }}"><i
                                                                class="fa fa-fw fa-eye"></i> </a>
                                                        <a class="btn btn-sm btn-success" tooltip="tooltip" title="Modificar"
                                                            href="{{ route('products.edit', $producto->id) }}"><i
                                                                class="fa fa-fw fa-edit"></i></a>
                                                        <!-- Modal de Confirmacion -->
                                                        @if ($producto->status == true)
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Inactivar"
                                                                data-bs-target="#confirmationDestroy-{{ $producto->id }}"><i
                                                                    class="fa fa-fw fa-trash"></i></button>
                                                        @else
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" tooltip="tooltip" title="Activar"
                                                                data-bs-target="#confirmationDestroy-{{ $producto->id }}"><i
                                                                    class="fa-solid fa-rotate"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    {{ $productos->links() }}
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
                        <div class="contenedor-notificacion" id="contenedor-notificacion">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- @include('sweetalert::alert') --}}
        @include('product.modal')
        @include('product.modalImport')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
        <script>
            new DataTable('#example', {
                responsive: true,
                paging: false,
                info: false,
                lengthChange: false,
                searching: false,
                ordering: false,
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
