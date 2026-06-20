@auth
@include('include.barra', ['modo' => 'Inicio'])
<br>
<div class="contenedor-toast" id="contenedor-toast">
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos_footer.css') }}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/dashboard/panel.css')}}">
    <script src="{{ asset('js/tooltips.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
</head>
<body>
    <div class="container-fluid px-5 py-3">
        <div class="col-sm-12">
            <!-- ========== Contenedores de Estadisticas ========== -->
            <div class="title">
                <h2>Panel Estadistícas</h2>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <div class="content">
                            <div class="info"> 
                                <h6 class="mb-10">Total Ventas Hoy</h6>
                                <h3 class="text-bold mb-10" style="color: rgb(17, 198, 0)">{{ '$' . number_format($totalVentasHoy, 0, ',', '.') }}</h3>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fa-solid fa-truck-fast fa-2xl" style="color: #6C9BCF"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card-default">
                        <div class="content">
                            <a class="info" href="{{route('sales.index')}}"> 
                                <h6 class="mb-10">Total de Ventas Realizadas </h6>
                                <h3 class="text-bold mb-10">{{{$sales}}}</h3>
                            </a>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fa-solid fa-cart-shopping fa-2xl" style="color: #1B9C85"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card-searches">
                        <div class="content">
                            <a class="info" href="{{route('detail-purchases.index')}}"> 
                                <h6 class="mb-10">Total de Compras Realizadas</h6>
                                <h3 class="text-bold mb-10">{{$purchase}}</h3>
                            </a>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fa-brands fa-shopify fa-2xl" style="color: #F7D060"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card-visits">
                        <div class="content">
                            <a class="info" href="{{route('products.index')}}"> 
                                <h6 class="mb-10">Total de Productos Existentes</h6>
                                <h3 class="text-bold mb-10">{{$productos}}</h3>
                            </a>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fa-brands fa-product-hunt fa-2xl" style="color: #FF0060"></i>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
            <!--Admin-->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card-style d-flex justify-content-center align-items-center h-100">
                    <div class="user-profile text-center">
                        <div class="logo">
                            @if(auth()->user()->hasRole('Administrador'))
                                <img src="{{ asset('img/dashboard/logo_admin.png') }}" class="img-fluid mb-3">
                            @elseif(auth()->user()->hasRole('Trabajador'))
                                <img src="{{ asset('img/dashboard/logo_empleado.png') }}" class="img-fluid mb-3">
                            @else
                                <img src="{{ asset('img/dashboard/logo_panel.png') }}" class="img-fluid mb-3">
                            @endif
                            @if(auth()->user()->roles->count() > 0)
                                <div class="mt-3">
                                    @foreach (auth()->user()->roles as $role)
                                        <p class="badge bg-dark fs-5">{{ $role->name }}</p>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-3">
                                    <p class="badge bg-dark fs-5">Sin Rol</p>
                                </div>
                            @endif
                            <h5 class="mt-2">{{ auth()->user()->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-6 mb-3">
                <div class="card-style">
                    <div class="title d-flex flex-wrap justify-content-between align-items-center">
                        <div class="left">
                            <h6 class="text-medium mb-30">Productos con pocas existencias</h6>
                        </div>
                    </div>
                    <div>
                        <table class="table table-striped table-hover w-100" id="example3">
                            <thead class="table-dark">
                                <tr>
                                    <th><h6 class="text-sm text-medium text-start">Nombre Producto</h6></th>
                                    <th><h6 class="text-sm text-medium text-start">Límite de Existencias</h6></th>
                                    <th><h6 class="text-sm text-medium text-start">Precio de Venta</h6></th>
                                    <th><h6 class="text-sm text-medium text-start">Estado</h6></th>
                                    <th><h6 class="text-sm text-medium text-start">Acción</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProduct as $data)
                                    <tr>
                                        <td class="text-start">{{ $data->name_product }}</td>
                                        <td class="text-start" >
                                            <p class="badge rounded-pill bg-danger" tooltip="tooltip" title="Pocas existencias">{{ $data->stock }}</p>
                                        </td>
                                        <td class="text-start">${{ number_format($data->selling_price, 0, ',', '.') }}</td>
                                        <td class="text-start">{{ ($data->status == 1) ? 'Activo' : 'Inactivo' }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" tooltip="tooltip" title="Aumentar Existencias" href="{{ route('detail-purchases.create') }}">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $dataProduct->links() }}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-style mb-30">
                      <div class="title d-flex flex-wrap justify-content-between align-items-center">
                        <div class="left">
                          <h6 class="text-medium mb-30">Compras Recientes</h6>
                        </div>
                      </div>
                      <div >
                        <table class="table top-selling-table w-100" id="example">
                          <thead class="table-dark" >
                            <tr>
                              <th><h6 class="text-sm text-medium text-start">N° Factura</h6></th>
                              <th><h6 class="text-sm text-medium text-start">Fecha</h6></th>
                              <th><h6 class="text-sm text-medium text-start">Proveedor</h6></th>
                              <th><h6 class="text-sm text-medium text-start">Forma de Pago</h6></th>
                              <th><h6 class="text-sm text-medium text-start">Estado</h6></th>
                              <th><h6 class="text-sm text-medium text-start">Total</h6></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ( $purchaseToday as $data )
                                <tr>
                                    <td class="text-start">{{ $data->purchaseSupplier->invoice_number_purchase}}</td>
                                    <td class="text-start">{{ $data->date_purchase}}</td>
                                    <td class="text-start">
                                        @if ($data->purchaseSupplier->person)
                                            @if ($data->purchaseSupplier->person->person_type === 'Persona jurídica')
                                                {{ $data->purchaseSupplier->person->company_name }}
                                            @else
                                                {{ $data->purchaseSupplier->person->first_name }}
                                                {{ $data->purchaseSupplier->person->surname }}
                                            @endif
                                        @else
                                            {{ 'nn' }}
                                        @endif
                                    </td>
                                    <td class="text-start">{{ $data->form_of_payment }}</td>
                                    <td class="text-start">{{ ($data->status == 1) ? 'Activo' : 'Inactivo' }} </td>
                                    <td class="text-start" style="color: rgb(17, 198, 0)">${{ number_format($data->total_value, 0, ',', '.')}}</td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{ $purchaseToday->links() }}

                      </div>
                    </div>
                  </div>
                <!-- End Col -->
                <div class="col-lg-6">
                  <div class="card-style mb-30">
                    <div class="title d-flex flex-wrap justify-content-between align-items-center">
                      <div class="left">
                        <h6 class="text-medium mb-30">Ventas recientes</h6>
                      </div>
                    </div>
                    <div >
                      <table class="table top-selling-table w-100" id="example2">
                        <thead class="table-dark" >
                          <tr>
                            <th><h6 class="text-sm text-medium text-start">N° Factura</h6></th>
                            <th><h6 class="text-sm text-medium text-start">Fecha</h6></th>
                            <th><h6 class="text-sm text-medium text-start">Vendedor</h6></th>
                            <th><h6 class="text-sm text-medium text-start">Forma de Pago</h6></th>
                            <th><h6 class="text-sm text-medium text-start">Estado</h6></th>
                            <th><h6 class="text-sm text-medium text-start">Total</h6></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ( $salesToday as $data )
                            <tr>
                                <td class="text-start">{{ $data->bill_numbers}}</td>
                                <td class="text-start">{{ $data->dates}}</td>
                                <td class="text-start">{{ $data->sellers}}</td>
                                <td class="text-start">{{ $data->payments_methods}}</td>
                                <td class="text-start">{{ ($data->status == 1) ? 'Activo' : 'Inactivo' }} </td>
                                <td class="text-start" style="color: rgb(17, 198, 0)">${{  number_format($data->net_total, 0, ',', '.')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      {{ $salesToday->links() }}
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <script src="{{ asset('js/datablesB.js') }}"></script>
</body>
</html>
@endauth
@guest
    @include('include.falta_sesion')
@endguest
