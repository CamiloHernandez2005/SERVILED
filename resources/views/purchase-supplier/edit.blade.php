@auth
@can('purchase_supplier')

@include('include.barra', ['modo'=>'Crear Compra Proveedor'])
    <div class="bread_crumb">
        {{ Breadcrumbs::render('compras.edit', $purchaseSupplier) }}
    </div>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Purchase Supplier</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('purchase_supplier.update', $purchaseSupplier->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf
                            @include('purchase-supplier.form')
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
