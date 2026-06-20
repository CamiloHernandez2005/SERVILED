@auth
    @include('include.barra', ['modo' => 'Detalle De Compra'])
    <br>

    <head>
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="css/estilos_notificacion.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
        <script src="{{ asset('js/notificaciones.js') }}" defer></script>
        <script src="{{ asset('js/tooltips.js') }}" defer></script>
    </head>
    @can('detail-purchases')
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ Breadcrumbs::render('compras.index') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">Acciones</button>
                                        <ul class="dropdown-menu desplegable_acciones">
                                            <div class="acciones_boton">
                                                <li><a class="dropdown-item" href="{{ route('detail-purchases.create') }}">Crear Compra
                                                </a></li>
                                                <li><a class="dropdown-item"
                                                    href="{{ route('debit-note-supplier.create') }}">Crear nota débito
                                                </a></li>

                                                <li><a class="dropdown-item"
                                                        href="{{ route('debit-note-supplier.index') }}">Mostrar notas débito</a></li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <form action="{{ route('detail-purchases.index') }}" method="get"
                                        class="d-flex align-items-center js-dt-export">

                                        {{-- Botones IMPORTAR Y EXPORTAR --}}

                                        <button type="button" class="btn btn-success ms-2 rounded" tooltip="tooltip"
                                            title="Excel" onclick="window.location.href='{{ route('export.purchase') }}'">
                                            <i class="fa-solid fa-file-excel"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger ms-2 rounded" tooltip="tooltip"
                                            title="PDF" onclick="window.open('{{ route('detail-purchases.pdf') }}','_blank')">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning ms-2 rounded" tooltip="tooltip"
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
                                    <table class="table table-striped table-hover w-100" id="datatable">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Número De Factura</th>
                                                <th class="text-center">Fecha De Elaboración</th>
                                                <th class="text-center">Identificación</th>
                                                <th class="text-center">Nombre Proveedor</th>
                                                <th class="text-center">Total Bruto</th>
                                                <th class="text-center">Iva</th>
                                                <th class="text-center">Descuento</th>
                                                <th class="text-center">Total Factura</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($detailPurchases as $detailPurchase)
                                                <tr class="text-center">
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $detailPurchase->purchaseSupplier->invoice_number_purchase ?? 'Error: No se encontró el número de factura' }}</td>
                                                    <td>{{ $detailPurchase->date_purchase ?? 'Error: No se encontró la fecha de elaboración' }}</td>
                                                    <td>{{ optional($detailPurchase->purchaseSupplier->person)->identification_type ?? 'Error: No se encontró el proveedor' }}</td>
                                                    <td>
                                                        @if ($detailPurchase->purchaseSupplier->person)
                                                            @if ($detailPurchase->purchaseSupplier->person?->person_type === 'Persona jurídica')
                                                                {{ $detailPurchase->purchaseSupplier->person?->company_name }}
                                                            @else
                                                                {{ $detailPurchase->purchaseSupplier->person?->first_name }}
                                                                {{ $detailPurchase->purchaseSupplier->person?->surname }}
                                                            @endif
                                                        @else
                                                            {{ 'nn' }}
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format($detailPurchase->gross_total, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($detailPurchase->product_tax, 0, ',', '.') }}%</td>
                                                    <td>${{ number_format($detailPurchase->discount_total, 0, ',', '.') }}</td>
                                                    <td>${{ number_format($detailPurchase->net_total, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if ($detailPurchase->status == 1)
                                                            <p class="badge rounded-pill bg-success text-white fs-6">
                                                                Activo</p>
                                                        @else
                                                            <p class="badge rounded-pill bg-danger text-white fs-6">
                                                                Inactivo</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form
                                                            action="{{ route('detail-purchases.destroy', $detailPurchase->id) }}"
                                                            method="POST">
                                                            <a class="btn btn-sm btn-primary" tooltip="tooltip"
                                                                title="Visualizar"
                                                                href="{{ route('detail-purchases.show', $detailPurchase->id) }}"><i
                                                                    class="fa fa-fw fa-eye"></i> {{ __('') }}</a>
                                                            @csrf
                                                            @method('DELETE')
                                                            @if ($detailPurchase->status == true)
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm"data-bs-toggle="modal"
                                                                    tooltip="tooltip" title="Inactivar"
                                                                    data-bs-target="#confirmationDestroy-{{ $detailPurchase->id }}"><i
                                                                        class="fa fa-fw fa-trash"></i></button>
                                                            @else
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal" tooltip="tooltip" title="Activar"
                                                                    data-bs-target="#confirmationDestroy-{{ $detailPurchase->id }}"><i
                                                                        class="fa-solid fa-rotate"></i></button>
                                                            @endif
                                                        </form>
                                                    </td>
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
            @include('detail-purchase.modal')
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
