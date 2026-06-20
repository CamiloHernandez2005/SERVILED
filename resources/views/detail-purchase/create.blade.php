@auth
@can('detail-purchases')

@include('include.barra', ['modo'=>'Crear Detalle de Compra'])

<div class="bread_crumb">
    {{ Breadcrumbs::render('detail.purchase.create') }}
</div>

    <form method="POST" action="{{ route('detail-purchases.store') }}"  role="form" enctype="multipart/form-data">
        @csrf

        @include('detail-purchase.form')

    </form>
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
