@auth
@include('include.barra', ['modo' => 'Informe Historia de Precios'])
<br>
@can('Historial_productos')

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css"> --}}
    <script src="{{asset('js/tooltips.js')}}" defer ></script>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-default">
                <div class="card-header d-flex">
                    <button type="button" class="btn btn-light">
                        <a href="{{route('index_informes')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        </a>
                    </button>
                    <h2 id="card_title">
                        {{ Breadcrumbs::render('PriceHystoryProducts') }}
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row border border-light p-2 mb-3 d-flex align-items-start">
                        <div class="col-12 col-md-6">
                            <form method="GET" action="{{ route('filtrar_por_fechas') }}">
                                <div class="form-group d-flex align-items-center">
                                    <div class="d-flex flex-column flex-grow-1 mr-2 mb-2">
                                        <label for="product_id" class="form-label @error('product_id') is-invalid @enderror fw-bolder">Producto</label>
                                        <select id="product_id" name="product_id" class="selectpicker form-control ml-2" data-live-search="true" aria-placeholder="Seleccione el producto" style="text-align-last:center;">
                                            <option value="">Seleccione el producto</option>
                                            @foreach ($product as $item)
                                                <option value="{{ $item->id }}-{{ $item->categoryProduct->name }}-{{ ($item->status == 1) ? 'Activo' : 'Inactivo' }}">{{ $item->name_product }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <div class=" col-md-6 d-flex flex-column flex-grow-1 mr-2 px-1 ">
                                        <label for="fecha_inicio" class="form-label @error('fecha_inicio') is-invalid @enderror fw-bolder">
                                            Fecha de inicio
                                        </label>
                                        <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control" style="text-align-last:left;"
                                               value="{{ request('fecha_inicio', old('fecha_inicio')) }}">
                                        @error('fecha_inicio')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class=" col-md-6 d-flex flex-column flex-grow-1 mr-2">
                                        <label for="fecha_cierre" class="form-label @error('fecha_cierre') is-invalid @enderror fw-bolder">
                                            Fecha de cierre
                                        </label>
                                        <input id="fecha_cierre" name="fecha_cierre" type="date" class="form-control" style="text-align-last:left;"
                                               value="{{ request('fecha_cierre', old('fecha_cierre')) }}">
                                        @error('fecha_cierre')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-dark">Filtrar</button>
                            </form>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group d-flex align-items-center">
                                <div class="d-flex flex-column flex-grow-1 mr-2 mb-2">
                                    <label for="categoria" class="form-label fw-bolder">Categoría Del Producto</label>
                                    <input disabled id="name" name="name" class="selectpicker form-control" data-live-search="true" style="text-align-last:left;"></input>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <div class="d-flex flex-column flex-grow-1 mr-2 mb-2">
                                    <label for="subcategoria" class="form-label fw-bolder">Estado</label>
                                    <input disabled id="status" name="status" class="selectpicker form-control" data-live-search="true" style="text-align-last:left;"></input>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="table_container">
                        <div>
                            <table class="table table-striped table-hover w-100" id="datatable">
                                <thead class="table-dark" >
                                    <tr class="text-center">
                                        <th>Categoría</th>
                                        <th>Subcategoría</th>
                                        <th>Nombre del producto</th>
                                        <th>Referencia de Fabrica</th>
                                        <th>N° Factura</th>
                                        <th>Fecha de la Factura</th>
                                        <th>Cantidad</th>
                                        <th>Total Bruto</th>
                                        <th>Descuento</th>
                                        <th>Subtotal</th>
                                        <th>Impuesto cargo</th>
                                        <th>Total Neto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $ventas)
                                    <tr>
                                        <td class="text-center">
                                            {{$ventas->producto->categoryProduct->name }}
                                        </td>
                                        <td class="text-center">
                                            {{$ventas->producto->subcategory_product }}
                                        </td>
                                        <td class="text-center">
                                            {{$ventas->producto->name_product }}
                                        </td>
                                        <td class="text-center">
                                            {{$ventas->producto->factory_reference }}
                                        </td>
                                        <td class="text-center">
                                            {{$ventas->venta->bill_numbers }}
                                        </td>
                                        <td class="text-center">{{ $ventas->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            {{$ventas->amount}}
                                        </td>
                                        <td class="text-center">
                                            ${{ number_format($ventas->venta->gross_totals, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            {{$ventas->discounts }}
                                        </td>
                                        <td class="text-center">
                                            ${{number_format(($ventas->amount) * ($ventas->selling_price) - ($ventas->discounts), 0, ',', '.')}}
                                        </td>
                                        <td class="text-center">{{ $ventas->tax }}%</td>
                                        <td class="text-center">${{ number_format($ventas->venta->net_total, 0, ',', '.') }}</td>


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
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date();
        today.setDate(today.getDate() - 1);
        var maxDate = today.toISOString().split('T')[0];
        document.getElementById('fecha_cierre').setAttribute('max', maxDate);
    });
</script>
<script>
    $(document).ready(function() {

    $('#product_id').change(mostrarValores);
    });

    function mostrarValores() {
        let dataProducto = document.getElementById('product_id').value.split('-');
        console.log(dataProducto)
        $('#name').val(dataProducto[1]);
        $('#status').val(dataProducto[2]);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>

    <script>
    new DataTable('#datatable',{
        responsive: true,
        lengthChange: true,
        // paging: false,
        searching: false,
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "<<",
                "sLast":     ">>",
                "sNext":     ">",
                "sPrevious": "<"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        layout: {
            topRight: {
                buttons: [
                    {
                        'extend': 'excelHtml5',
                        'text': '<i class="fa fa-file-excel"></i>',
                        'className': 'btn btn-success',
                        'attr': {
                            'tooltip': 'tooltip',
                            'title': 'Excel'
                        }
                    },
                    {
                        'extend': 'pdfHtml5',
                        'text': '<i class="fa fa-file-pdf"></i>',
                        'className': 'btn btn-danger',
                        'orientation': 'landscape',
                        'pageSize': 'LEGAL',
                        'download': 'open',
                        'attr': {
                            'tooltip': 'tooltip',
                            'title': 'PDF'
                        }
                    }
                ]
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
