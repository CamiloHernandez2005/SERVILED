@auth
@include('include.barra', ['modo'=>'Detalle de Compra'])
@can('detail-purchases')

@section('content')

    <form method="POST" action="{{ route('detail-purchases.update', $detailPurchase->id) }}"  role="form" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
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
