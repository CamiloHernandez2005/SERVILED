@auth
@can('purchase_supplier')

@include('include.barra', ['modo'=>'Detalles de la Compra'])
    <div class="bread_crumb">
        {{ Breadcrumbs::render('compras.show', $purchaseSupplier) }}
    </div>
<section class="content container-fluid">
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ __('Detalles de la Compra') }}</span>
                </div>
                <div class="card-body">
                    <form>
                        @csrf

                        <div class="form-group">
                            {{ Form::label('Numero De Factura', null, ['class' => 'form-label']) }}
                            {{ Form::text('invoice_number_purchase', $purchaseSupplier->invoice_number_purchase, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('Numero De Prefijo', null, ['class' => 'form-label']) }}
                            {{ Form::text('code', $purchaseSupplier->code, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('Fecha De La Factura De Compra', null, ['class' => 'form-label']) }}
                            {{ Form::date('date_invoice_purchase', $purchaseSupplier->date_invoice_purchase, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('Empleado A Cargo De La Compra', null, ['class' => 'form-label']) }}
                            {{ Form::select('users_id', $users->pluck('name', 'id'), $purchaseSupplier->users_id, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('Proveedor', null, ['class' => 'form-label']) }}
                            {{ Form::select('people_id', $people->pluck('first_name', 'id'), $purchaseSupplier->people_id, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                        </div>

                        <div class="form-group">
                            <a class="btn btn-primary" href="{{ route('purchase_supplier.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
