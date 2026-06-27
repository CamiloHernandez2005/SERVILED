{{-- <!DOCTYPE html> --}}
@auth

    @can('products')
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </head>
        <br>

        <body>
            <div class="container-fluid">
                <div class="page-body">
                    <div class="container-x1">
                        <div class="row row-cards">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    {{ __('Imagen Producto') }}
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <img class="img-account-profile mb-2"
                                                    src="{{ asset('img/products/default.webp') }}" id="image-preview"
                                                    width="400" height="400" />

                                                <div class="small font-italic text-muted mb-2 fw-bolder">
                                                    JPG o PNG no sea mas grande de 2MB
                                                </div>

                                                @if (isset($producto->photo))
                                                    <img src="{{ asset('storage/' . $producto->photo) }}" width="350"
                                                        height="350">
                                                @endif

                                                <input type="file" accept="image/*" id="image" name="photo"
                                                    class="form-control @error('photo') is-invalid @enderror"
                                                    onchange="previewImage();">

                                                @error('photo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    {{ __('Producto') }}
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row row-cards">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="validationProduct" class="form-label fw-bolder">
                                                            {{ __('Nombre del producto') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('name_product', $producto->name_product, ['class' => 'form-control' . ($errors->has('name_product') ? ' is-invalid' : ''), 'placeholder' => 'Nombre', 'id' => 'validationProduct']) }}
                                                        {!! $errors->first('name_product', '<div class="invalid-feedback">:message</div>') !!}
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 mb-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bolder" for="unidades_id">
                                                                {{ __('Unidad de medida') }}
                                                            </label>
                                                            {{ Form::select('measurement_units_id', $unidades, $producto->measurement_units_id, [
                                                                'class' =>
                                                                    'form-control selectpicker show-tick custom-select-size' .
                                                                    ($errors->has('measurement_units_id') ? ' is-invalid' : ''),
                                                                'data-live-search' => 'true',
                                                                'data-width' => 'auto',
                                                                'data-size' => '5',
                                                                'data-dropup-auto' => 'false',
                                                            ]) }}
                                                            {!! $errors->first('measurement_units_id', '<div class="invalid-feedback">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 mb-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bolder" for="classification_tax">
                                                                {{ __('Clasificación tributaria') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            {{ Form::select('classification_tax', ['0%' => '0%', '5%' => '5%', '19%' => '19%'], $producto->classification_tax, ['class' => 'form-control selectpicker' . ($errors->has('classification_tax') ? ' is-invalid' : ''), 'placeholder' => 'Selecione Una', 'data-live-search' => 'true']) }}
                                                            {!! $errors->first('classification_tax', '<div class="invalid-feedback">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 mb-3">
                                                        <label class="form-label fw-bolder" for="factory_reference">
                                                            {{ __('Referencia de fábrica') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('factory_reference', $producto->factory_reference, ['class' => 'form-control' . ($errors->has('factory_reference') ? ' is-invalid' : ''), 'placeholder' => 'Referencia de fábrica']) }}
                                                        {!! $errors->first('factory_reference', '<div class="invalid-feedback">:message</div>') !!}
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 mb-3">
                                                        <label class="form-label fw-bolder" for="tax_type">
                                                            {{ __('Marca del producto') }}
                                                        </label>
                                                        {{ Form::select('brands_id', $marcas, $producto->brands_id, ['class' => 'form-control selectpicker' . ($errors->has('brands_id') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona una marca', 'data-live-search' => 'true', 'data-size' => '5']) }}
                                                        {!! $errors->first('brands_id', '<div class="invalid-feedback">:message</div>') !!}
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 mb-3">
                                                        <label class="form-label fw-bolder" for="selling_price">
                                                            {{ __('Precio de venta sin IVA') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::number('selling_price', $producto->selling_price, ['class' => 'form-control ' . ($errors->has('selling_price') ? ' is-invalid' : ''), 'placeholder' => '0', 'id' => 'selling_price']) }}
                                                        {!! $errors->first('selling_price', '<div class="invalid-feedback">:message</div>') !!}
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="notes" class="form-label fw-bolder">
                                                                {{ __('Descripción') }}
                                                            </label>
                                                            {{ Form::textarea('description_long', $producto->description_long, ['class' => 'form-control' . ($errors->has('description_long') ? ' is-invalid' : ''), 'placeholder' => 'Descripción Producto', 'rows' => '3']) }}
                                                            {!! $errors->first('description_long', '<div class="invalid-feedback">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer text-end">
                                                <a class="btn btn btn-primary"
                                                    href="{{ route('products.index') }}">Regresar</a>
                                                <button class="btn btn btn-success"
                                                    type="submit">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script src="{{ asset('js/img-preview.js') }}"></script>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        </body>

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
