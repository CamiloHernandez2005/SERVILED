@auth
@can('person')

@if ($table === 'supplier')
    <div class="bread_crumb">
        {{ Breadcrumbs::render('supplier.edit', $person) }}
    </div>
@elseif ($table === 'customer')
    <div class="bread_crumb">
        {{ Breadcrumbs::render('customer.edit', $person) }}
    </div>
@endif
    <form method="POST" action="{{ route('person.update', $person->id) }}"  role="form" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        @csrf

        @include('person.form')

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
