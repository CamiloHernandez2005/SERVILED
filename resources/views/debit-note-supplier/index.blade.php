@auth
    @include('include.barra', ['modo' => 'Notas Debito'])
    @can('debit-note-supplier')

        <head>
            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <link href="css/estilos_notificacion.css" rel="stylesheet" />
            <script src="{{ asset('js/notificaciones.js') }}" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
            <script src="{{ asset('js/tooltips.js') }}" defer></script>
        </head>
        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ Breadcrumbs::render('debit-note-supplier.index') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">Acciones</button>
                                    <ul class="dropdown-menu">

                                        <li><a class="dropdown-item"
                                            href="{{ route('debit-note-supplier.create') }}">Crear nota débito
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('detail-purchases.create') }}">Crear Compra
                                        </a></li>


                                        <li><a class="dropdown-item"
                                                href="{{ route('detail-purchases.index') }}">Mostrar Compras</a></li>
                                    </ul>
                                </div>
                                <form action="{{ route('debit-note-supplier.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                                    <input type="text" name="filtervalue" class="form-control" placeholder="Buscar nota débito..." value="{{ request('filtervalue') }}">
                                    <button type="submit" class="btn btn-dark">Buscar</button>
                                </form>
                                <div class="ms-auto d-flex align-items-center gap-2">
                                    <form action="{{ route('debit-note-supplier.index') }}" method="get"
                                        class="d-flex align-items-center gap-2 mb-0 js-dt-export">
                                        <button type="button" class="btn btn-success rounded" tooltip="tooltip"
                                            title="Excel" onclick="window.location.href='{{ route('export.debitnote') }}'">
                                            <i class="fa-solid fa-file-excel"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger rounded" tooltip="tooltip"
                                            title="PDF" onclick="window.open('{{ route('debit-note-supplier.pdf') }}','_blank')">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning rounded" tooltip="tooltip"
                                            title="Importar" data-bs-toggle="modal" data-bs-target="#importPerson">
                                            <i class="fa-solid fa-folder-open"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

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
                        <style>
                            .card-body {
                                padding-bottom: 0;
                            }

                            .table_container {
                                margin-top: 0;
                            }

                            #example th,
                            #example td {
                                text-align: center !important;
                            }
                        </style>
                        <div class="container_datos">
                            <div class="table_container p-3">
                                <div>
                                    <table id="datatable" class="table table-striped table-hover w-100">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th>Nº</th>
                                                <th>Fecha De Elaboración</th>
                                                <th>Identificación</th>
                                                <th>Nombre Proveedor</th>
                                                <th>Total Bruto</th>
                                                <th>Iva</th>
                                                <th>Descuento</th>
                                                <th>Total Factura</th>
                                                <th>Motivo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($debitNoteSuppliers as $key => $debitNoteSupplier)
                                                <tr class="text-center">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $debitNoteSupplier->date_invoice ?? 'Error: No se encontró la fecha de elaboración' }}</td>
                                                    <td>{{ optional($debitNoteSupplier->detailPurchase->purchaseSupplier->person)->identification_number ?? 'Error: No se encontró el Empleado' }}</td>
                                                    <td>
                                                        @if (optional($debitNoteSupplier->purchaseSupplier->person)->person_type === 'Persona jurídica')
                                                            {{ optional($debitNoteSupplier->purchaseSupplier->person)->company_name ?? 'Error: No se encontró la Empresa' }}
                                                        @else
                                                            {{ optional($debitNoteSupplier->purchaseSupplier->person)->first_name ?? 'Error: No se encontró el Empleado' }}
                                                            {{ optional($debitNoteSupplier->purchaseSupplier->person)->surname ?? '' }}
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format($debitNoteSupplier->gross_total, 0, ',', '.') ?? 'Error: No se encontró el total bruto' }}</td>
                                                    <td>{{ number_format(optional($debitNoteSupplier->detailPurchase)->product_tax, 0, ',', '.') }}%</td>
                                                    <td>${{ number_format(optional($debitNoteSupplier->detailPurchase)->discount_total, 0, ',', '.') ?? 'Error: No se encontró el descuento total' }}</td>
                                                    <td>${{ number_format($debitNoteSupplier->net_total, 0, ',', '.') ?? 'Error: No se encontró el total de la factura' }}</td>
                                                    <td class="text-center text-truncate" style="max-width: 100px;">
                                                        {{ $debitNoteSupplier->motive ?? 'Error: No se encontró el motivo' }}
                                                    </td>
                                                                                                        <td>
                                                        @if ($debitNoteSupplier->status == 1)
                                                            <p class="badge rounded-pill bg-success text-white fs-6">Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger text-white fs-6">
                                                                Inactivo</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form
                                                            action="{{ route('debit-note-supplier.destroy', $debitNoteSupplier->id) }}"
                                                            method="POST">
                                                            <a class="btn btn-sm btn-primary "tooltip="tooltip"
                                                                title="Visualizar"
                                                                href="{{ route('debit-note-supplier.show', $debitNoteSupplier->id) }}"><i
                                                                    class="fa fa-fw fa-eye"></i> {{ __('') }}</a>
                                                            @csrf
                                                            @method('DELETE')
                                                            @if ($debitNoteSupplier->status == true)
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal"tooltip="tooltip" title="Inactivar"
                                                                    data-bs-target="#confirmationDestroy-{{ $debitNoteSupplier->id }}"><i
                                                                        class="fa fa-fw fa-trash"></i></button>
                                                            @else
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal"tooltip="tooltip" title="Activar"
                                                                    data-bs-target="#confirmationDestroy-{{ $debitNoteSupplier->id }}"><i
                                                                        class="fa-solid fa-rotate"></i></button>
                                                            @endif

                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3 d-flex justify-content-center">
                                        {{ $debitNoteSuppliers->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            @include('debit-note-supplier.modal')
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
            <script src="{{ asset('js/datatable.js') }}" defer></script>
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
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
