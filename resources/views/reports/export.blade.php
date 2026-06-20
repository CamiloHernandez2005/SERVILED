@auth

    @include('include.barra', ['modo' => 'Informes'])
    <br>
@can('reports')

    <head>
        <link rel="stylesheet" href="{{ asset('css/report/style.css') }}">
    </head>
    <div class="container-fluid px-5 py-8">
        <div class="col-sm-12">
            <!-- ========== Contenedores de Estadisticas ========== -->
            <div class="title">
                <h2>{{ Breadcrumbs::render('informes.index') }}</h2>
            </div>
            <div class="row px-lg-5">
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <a class="content" href="{{route('reportPriceHistoryProducts')}}">
                            <div class="info">
                                <h4 class="mb-10">
                                    Generar Informe Historial de Precios de las Ventas
                                </h4>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fa-solid fa-magnifying-glass-dollar fa-2xl" style="color: #00b3ff"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <a class="content" href="{{route('reportPriceHistoryProductsPurchase')}}">
                            <div class="info">
                                <h4 class="mb-10">
                                    Generar Informe Historial de Precios de las Compras
                                </h4>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fa-solid fa-coins fa-2xl" style="color: #00b3ff"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <a class="content" href="{{route('historial')}}">
                            <div class="info">
                                <h4 class="mb-10">
                                    Generar Informe Historial de Movimientos de los Productos
                                </h4>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fas fa-exchange-alt fa-2xl" style="color: #00b3ff"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <a class="content" href="{{route('units.index')}}">
                            <div class="info">
                                <h4 class="mb-10">Consultar Unidades de Medida</h4>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fas fa-ruler fa-2xl" style="color: #00b3ff"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <a class="content" href="{{route('municipalities.index')}}">
                            <div class="info">
                                <h4 class="mb-10">Consultar Municipios</h4>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fas fa-city fa-2xl" style="color: #00b3ff"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="icon-card-sales">
                        <a class="content" href="">
                            <div class="info">
                                <h4 class="mb-10">Otros</h4>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <i class="fas fa-ellipsis-h fa-2xl" style="color: #00b3ff"></i>
                                </div>
                            </div>
                        </a>
                    </div>
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
