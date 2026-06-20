@auth
@can('purchase_supplier')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('Crear Compra') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('purchase_supplier.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            {{ Form::label('Numero De Factura', null, ['class' => 'form-label']) }}
                            {{ Form::text('invoice_number_purchase', $purchaseSupplier->invoice_number_purchase ?? null, ['class' => 'form-control' . ($errors->has('invoice_number_purchase') ? ' is-invalid' : ''), 'placeholder' => 'Numero De Factura']) }}
                            {!! $errors->first('invoice_number_purchase', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('Prefijo', null, ['class' => 'form-label']) }}
                            {{ Form::text('code', $purchaseSupplier->code?? null, ['class' => 'form-control' . ($errors->has('code') ? ' is-invalid' : ''), 'placeholder' => 'Numero De Prefijo']) }}
                            {!! $errors->first('code', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group">
                            {{ Form::label('Fecha De La Factura De Compra', null, ['class' => 'form-label']) }}
                            {{ Form::date('date_invoice_purchase', $purchaseSupplier->date_invoice_purchase ?? null, ['class' => 'form-control' . ($errors->has('date_invoice_purchase') ? ' is-invalid' : ''), 'placeholder' => 'Dia De Creacion De La Compra']) }}
                            {!! $errors->first('date_invoice_purchase', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group">
                            {{ Form::label('Empleado A Cargo De La Compra', null, ['class' => 'form-label']) }}
                            {{ Form::select('users_id', $users->pluck('name', 'id'), $purchaseSupplier->users_id ?? null, ['class' => 'form-control' . ($errors->has('users_id') ? ' is-invalid' : ''), 'placeholder' => __('Seleccione un Empleado')]) }}
                            {!! $errors->first('users_id', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group">
                            {{ Form::label('Proveedor', 'Proveedor (opcional)', ['class' => 'form-label']) }}
                            {{ Form::select('people_id', $people->pluck('first_name', 'id'), $purchaseSupplier->people_id ?? null, ['class' => 'form-control' . ($errors->has('people_id') ? ' is-invalid' : ''), 'placeholder' => __('Seleccione un proveedor (opcional)')]) }}
                            {!! $errors->first('people_id', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-success "><a href="{{route('purchase_supplier.index')}}">{{ __('Back') }}</button></a>
                            <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <div class="mensaje_Rol">
        <img src="{{ asset('img/Rol_no_asignado.png')}}" class="img_rol"/>
        <h2 class="texto_noRol">Pídele al administrador que se te asigne un rol.</h2>
    </div>
@endcan
@endauth

@guest
@include('include.falta_sesion')
@endguest
