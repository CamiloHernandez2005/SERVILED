@auth
    @include('include.barra', ['modo' => 'Compra Proveedor'])

    <head>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    </head>
    @can('purchase_supplier')
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <div class="card">
                        <div class="card">
                            <div class="card-header">
                                <h2 id="card_title">
                                    {{ Breadcrumbs::render('compras.index') }}
                                </h2>
                            </div>
                            <div class="card-body"></div>
                            <div class="row">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('detail-purchases.index') }}">Mostrar Detalles De
                                                            Compras</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('debit-note-supplier.index') }}">Mostrar notas
                                                            debito</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form class="d-flex align-items-center justify-content-end">

                                                <button type="button" class="btn btn-success ms-2 rounded"
                                                    data-bs-toggle="tooltip" title="Exportar"
                                                    onclick="window.location.href='{{ route('export.purchase') }}'">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                </button>
                                        
                                            </form>
                                        </div>
                                    </div>
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
                        <div class="container_datos">
                            <div class="table_container">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="datatable">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Tipo Documento</th>
                                                <th>Numero Documento</th>
                                                <th>Proveedor</th>
                                                <th>Numero Factura De Proveedor</th>
                                                <th>Fecha De Compra</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($purchaseSuppliers as $purchaseSupplier)
                                                <tr>
                                                    <td class="text-center">{{ ++$i }}</td>
                                                    <td>{{ $purchaseSupplier->person ? $purchaseSupplier->person->identification_type : 'N/A' }}
                                                    </td>
                                                    <td>{{ $purchaseSupplier->person ? $purchaseSupplier->person->identification_number : 'N/A' }}
                                                    </td>
                                                    <td>{{ $purchaseSupplier->person ? $purchaseSupplier->person->first_name : 'N/A' }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $purchaseSupplier->invoice_number_purchase }}</td>
                                                    <td class="text-center">
                                                        {{ $purchaseSupplier->date_invoice_purchase }}</td>
                                                    <td class="text-center">
                                                        <form
                                                            action="{{ route('purchase_supplier.destroy', $purchaseSupplier->id) }}"
                                                            method="POST">
                                                            <a class="btn btn-sm btn-primary "
                                                                href="{{ route('purchase_supplier.show', $purchaseSupplier->id) }}"
                                                                title="{{ __('Visualizar') }}"><i class="fa fa-fw fa-eye"></i>
                                                                {{ __('Mostrar') }}</a>
                                                            <a class="btn btn-sm btn-success"
                                                                href="{{ route('purchase_supplier.edit', $purchaseSupplier->id) }}"
                                                                title="{{ __('Modificar') }}"><i class="fa fa-fw fa-edit"></i>
                                                                {{ __('Editar') }}</a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                title="{{ __('Eliminar') }}"><i
                                                                    class="fa fa-fw fa-trash"></i></button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script src="{{ asset('js/notificaciones.js') }}" defer></script>
                        <script src="{{ asset('js/tooltips.js') }}" defer></script>
                        <script src="{{ asset('js/datatable.js') }}" defer></script>
                        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
                        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
                        <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
                        <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
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
