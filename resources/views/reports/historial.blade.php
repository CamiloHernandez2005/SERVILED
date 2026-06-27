@auth
@include('include.barra', ['modo' => 'Historial De Movimientos'])
<br>
@can('Product_movement')

<!DOCTYPE html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
<link href="css/estilos_notificacion.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
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
                        {{ Breadcrumbs::render('movement_history') }}
                    </h2>
                </div>
              
                <form method="POST" action="{{ route('buscar.historial') }}">
                    @csrf
                <div class="card-body">
                    <div class="row border border-light p-2 mb-3 d-flex align-items-start">
                        <div class="col-12 col-md-6">
                            <div class="form-group d-flex align-items-center mt-2">
                                <div class="d-flex flex-column flex-grow-1 mr-2 mb-3">
                                    <label for="producto" class="form-label">Producto</label>
                                    <select name="producto" id="producto" class="selectpicker form-control ml-2" data-live-search="true" style="text-align-last:center;">
                                        <option value="" selected disabled>Seleccione un Producto</option>

                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name_product }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                                <span id="buscar" class="mx-3"></span>
                                <a href="/limpiar" class="btn btn-secondary">Limpiar</a>
                            </div>

                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group d-flex align-items-center">
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                        <input name="fecha_inicio" id="fecha_inicio" type="date" class="form-control" style="text-align-last:center;">
                                    </div>
                                </div>
                                <div class="form-group d-flex align-items-center mt-3">
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <label for="fecha_cierre" class="form-label">Fecha de cierre</label>
                                        <input name="fecha_cierre" id="fecha_cierre" type="date" class="form-control" style="text-align-last:center;">
                                    </div>
                                </div>

                                <div class="form-group d-flex align-items-center mt-2">
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select name="estado" id="estado" class="selectpicker form-control ml-2" data-live-search="true" style="text-align-last:center;">
                                            <option value="" selected disabled>Seleccione un Estado</option>
                                            @foreach($estados as $estado)
                                                <option value="{{ $estado == 'Activo' ? 1 : 0 }}">{{ $estado }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </form>
                        <div class="table_container">
                            <div>
                                <table class="table table-striped table-hover w-100" id="datatable">
                                    <thead class="table-dark">
                                        <tr class="text-center">
                                            <th>Nombre Del Producto</th>
                                            <th>Referencia De Fabrica</th>
                                            <th>Cantidad Entrada</th>
                                            <th>Fecha Inicial </th>
                                            <th>Fecha Final</th>
                                            <th>Fecha De La Factura</th>
                                            <th>Cantidad De Salida</th>
                                            <th>Saldo De Cantidades</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $detallesCompras = \App\Models\DetailPurchase::orderBy('created_at')->get()->groupBy('products_id');
                                    @endphp
                                    <tbody>

                                </tbody>
                            </table>
                        </div>
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
  var table = $('#datatable').DataTable({
    responsive: true,
    autoWidth: false,
    searching: false,
    language: {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros por página",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla intente filtrar ",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "sPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    columnDefs: [{
        targets: '_all',
        defaultContent: 'N/A'
    }],
    data: @json($datos),
    columns: [
        { data: 'nombre_del_producto' },
        { data: 'referencia_de_fabrica' },
        { data: 'cantidad_entrada' },
        { data: 'fecha_inicial' },
        { data: 'fecha_final' },
        { data: 'fecha_de_la_factura' },
        { data: 'cantidad_de_salida' },
        { data: 'saldo_de_cantidades' }
    ],
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
<style>
    #datatable tbody td {
        text-align: center;
    }
</style>
</html>
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
