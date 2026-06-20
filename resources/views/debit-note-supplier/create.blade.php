@auth
@can('debit-note-supplier')


<div class="bread_crumb">
    {{ Breadcrumbs::render('debit.note.supplier.create') }}
</div>
    <form method="POST" action="{{ route('debit-note-supplier.store') }}"  role="form" enctype="multipart/form-data">
        @csrf

     @include('debit-note-supplier.form')
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
