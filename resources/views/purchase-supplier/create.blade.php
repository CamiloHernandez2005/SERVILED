@auth

@include('include.barra', ['modo'=>'Crear Compra Proveedor'])
@can('purchase_supplier')

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')


                <div class="card card-default">
                   <div class="card-header">
                        {{-- <span class="card-title">{{ __('Create') }} Purchase Supplier</span> --}}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('purchase_supplier.store') }}"  role="form" enctype="multipart/form-data">
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
