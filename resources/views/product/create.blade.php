@auth
    @can('products')
        @include('include.barra', ['modo' => 'Crear Producto'])
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Crear Producto</title>
        </head>
        <body>
            <div class="bread_crumb">
                {{ Breadcrumbs::render('product.create') }}
            </div>
            <form method="POST" action="{{ route('products.store') }}" role="form" enctype="multipart/form-data">
                @csrf
                @include('product.form')
            </form>
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
