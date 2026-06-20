@auth
    @can('categorySub')
        @include('include.barra', ['modo' => 'Crear Subcategoría'])
        <br>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @includeif('partials.errors')
                    <div class="card card-default">
                        <div class="card-header">
                            <h2 id="card_title">
                                {{ __('Subcategoría') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('categorySub.store') }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                @include('sub-category.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
