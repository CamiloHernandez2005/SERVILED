@auth
    @can('sales')
        @extends('template')

        @push('css')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
        @endpush

        @section('content')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <div class="card">
                            <div class="card-header">
                                <h2 id="card_title">
                                    {{ Breadcrumbs::render('sales.index') }}
                                </h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">

                                        {{-- Desplegable de opciones --}}
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">Acciones</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('sales.create') }}">Crear
                                                        venta</a></li>
                                                <li><a class="dropdown-item" href="{{ route('credit-note-sales.create') }}">Crear
                                                        nota crédito</a></li>
                                                <li><a class="dropdown-item" href="{{ route('credit-note-sales.index') }}">Mostrar
                                                        nota crédito</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <form action="{{ route('sales.index') }}" method="get" class="d-flex align-items-center js-dt-export">

                                            {{-- Botones IMPORTAR Y EXPORTAR --}}

                                            <button type="button" class="btn btn-success ms-2 rounded" tooltip="tooltip"
                                                title="Excel" onclick="window.location.href='{{ route('export.sale') }}'">
                                                <i class="fa-solid fa-file-excel"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger ms-2 rounded" tooltip="tooltip"
                                                title="PDF" onclick="window.open('{{ route('sales.pdf') }}','_blank')">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning ms-2 rounded" tooltip="tooltip"
                                                title="Importar" data-bs-toggle="modal" data-bs-target="#importPerson">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                                <br>

                <div>
                    <table class="table table-striped table-hover w-100" id="datatable">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Comprobante</th>
                                        <th>Fecha elaboración</th>
                                        <th>Identificación</th>
                                        <th>Nombre tercero</th>
                                        <th>Total Bruto</th>
                                        <th>IVA</th>
                                        <th>Total Descuentos</th>
                                        <th>Total Factura</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventasFiltradas as $sale)
                                    <tr class="text-center">
                                        <td>{{$sale->id}}</td>
                                        <td>{{$sale->bill_numbers}}</td>
                                        <td>{{$sale->dates}}</td>
                                        <td>{{$sale->cliente?->identification_number}}</td>
                                        <td>{{ "{$sale->cliente?->company_name} {$sale->cliente?->first_name} {$sale->cliente?->other_name} {$sale->cliente?->surname} {$sale->cliente?->second_surname}" }}</td>
                                        <td>${{ number_format($sale->gross_totals, 0, ',', '.') }}</td>
                                        <td>${{ number_format($sale->taxes_total, 0, ',', '.') }}</td>
                                        <td>${{ number_format($sale->total_discounts, 0, ',', '.') }}</td>
                                        <td>${{ number_format($sale->net_total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($sale->status == True)
                                            <p class="badge rounded-pill bg-success fs-6">Activo</p>
                                            @else
                                            <p class="badge rounded-pill bg-danger fs-6">Inactivo</p>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2 text-center">
                                            <div class="d-inline-block">
                                                <form action="{{ route('sales.show', ['sale' => $sale]) }}" method="get">
                                                    <button type="submit" class="btn btn-primary btn-sm" tooltip="tooltip" title="Visualizar">
                                                        <i class="fa fa-fw fa-eye"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="d-inline-block">
                                                <a href="{{ route('sales.factura-pos', $sale->id) }}" target="_blank" class="btn btn-info btn-sm" tooltip="tooltip" title="Factura POS">
                                                    <i class="fa-solid fa-receipt"></i>
                                                </a>
                                            </div>
                                            <div class="d-inline-block">
                                                @if ($sale->status == true)
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" tooltip="tooltip" title="Inactivar" data-bs-target="#confirmModal-{{$sale->id}}"><i class="fa fa-fw fa-trash"></i></button>
                                            @else
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" tooltip="tooltip" title="Activar" data-bs-target="#confirmModal-{{$sale->id}}"><i class="fa-solid fa-rotate"></i></button>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="confirmModal-{{$sale->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($sale->status == true)
                                                    ¿Seguro que quieres inactivar el registro?
                                                @else
                                                    ¿Seguro que quieres activar el registro?
                                                @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                                    <form action="{{ route('sales.destroy',['sale'=>$sale->id]) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


            </div>
        </div>
    </div>
</div>
@endsection


            @push('js')
                <script src="{{ asset('js/datatable.js') }}" defer></script>
                <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
                <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
                <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
                <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

                {{-- Al guardar una venta, abre automáticamente su factura POS en una pestaña nueva --}}
                @if (session('factura_pos_id'))
                    <script>
                        window.open("{{ route('sales.factura-pos', session('factura_pos_id')) }}", "_blank");
                    </script>
                @endif
            @endpush
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
