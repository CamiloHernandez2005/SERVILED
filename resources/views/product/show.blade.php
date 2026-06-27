@auth
    @can('products')
        @include('include.barra', ['modo' => 'Productos'])

        <body>
            <div class="bread_crumb">
                {{ Breadcrumbs::render('product.show', $producto) }}
            </div>
            <br>
            <div class="container-fluid">
                <div class="page-body">
                    <div class="row row-cards">
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title text-center">
                                            {{ __('Imagen Producto') }}
                                        </h3>
                                    </div>
                                    <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    @if ($producto->photo)
                                                        <img class="rounded mx-auto d-block"
                                                            src="{{ asset('storage/' . $producto->photo) }}" width="250"
                                                            height="250">
                                                    @else
                                                        <img class="rounded mx-auto d-block"
                                                            src="{{ asset('img/products/default.webp') }}" width="250"
                                                            height="250">
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            {{ __('Detalles del Producto') }}
                                        </h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table card-table   text-nowrap datatable">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bxs-package'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Nombre: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span title="Número de comprobante" id="icon-form"
                                                                class="input-group-text"><i class='bx bxs-package'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $producto->name_product }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bx-text'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Descripción: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bx-text'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $producto->description_long }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bx-hive'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Existencias: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bx-hive'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $producto->stock }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-cube"></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Unidad de Medida: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-cube"></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $producto->measurementUnit?->name ?? 'N/A' }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class='bx bx-refresh'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Estado: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class='bx bx-refresh'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value=" {{ $producto->status == 1 ? 'Activo' : 'Inactivo' }} ">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-newspaper"></i></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Referencia Fabrica: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-newspaper"></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value=" {{ $producto->factory_reference }} ">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bxs-label'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Clasificacion Tributaria: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bxs-label'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value=" {{ $producto->classification_tax }} ">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class='bx bx-dollar-circle'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Precio de Compra: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class='bx bx-dollar-circle'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value=" ${{ number_format($producto->purchase_price, 0, ',', '.') }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class='bx bx-dollar-circle'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Precio de Venta sin IVA: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i
                                                                    class='bx bx-dollar-circle'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="${{ number_format($producto->selling_price, 0, ',', '.') }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bxs-label'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value="Marca: ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" id="hide-group">
                                                            <span class="input-group-text"><i class='bx bxs-label'></i></span>
                                                            <input disabled type="text" class="form-control"
                                                                value=" {{ $producto->brand?->name ?? 'N/A' }} ">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer text-end">
                                        <a class="btn btn-primary" href="{{ route('products.index') }}">
                                            {{ __('Regresar') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
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
