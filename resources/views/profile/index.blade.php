@auth
    @include('include.barra', ['modo' => 'Configuración'])
    @can('profile')
    <head>
        <link rel="stylesheet" href="{{asset('css/dashboard/panel.css')}}">
        <link rel="stylesheet" href="{{asset('css/estilos_notificacion.css')}}">
        <script src="{{ asset('js/notificaciones.js')}}" defer></script>
    </head>
    <div class="bread_crumb">
        {{ Breadcrumbs::render('profile') }}
    </div>
    <br>
    <div class="container-fluid">
        <div class="row">
            {{-- Columna para la imagen del perfil --}}
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="user-profile text-center">
                            <div class="logo">
                                @if(auth()->user()->hasRole('Administrador'))
                                    <img src="{{ asset('img/dashboard/logo_admin.png') }}" class="img-fluid mb-3">
                                @elseif(auth()->user()->hasRole('Trabajador'))
                                    <img src="{{ asset('img/dashboard/logo_empleado.png') }}" class="img-fluid mb-3">
                                @else
                                    <img src="{{ asset('img/dashboard/logo_panel.png') }}" class="img-fluid mb-3">
                                @endif
                                @if(auth()->user()->roles->count() > 0)
                                    <div class="mt-3">
                                        @foreach (auth()->user()->roles as $role)
                                            <p class="badge bg-dark fs-5">{{ $role->name }}</p>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <p class="badge bg-dark fs-5">Sin Rol</p>
                                    </div>
                                @endif
                                <h5 class="mt-2">{{ auth()->user()->name }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Columna para la información del usuario --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Datos del usuario
                    </div>
                    <div class="card-body">
                        {{--  Nombre del usuario  --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="input-group" id="hide-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-signature"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="Nombre de usuario: ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span title="Nombre de usuario" id="icon-form" class="input-group-text">
                                        <i class="fa-solid fa-signature"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="{{ old('name', $user->name) }}">
                                </div>
                            </div>
                        </div>

                        {{--  Correo del usuario  --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="input-group" id="hide-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="Correo electrónico : ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span title="Correo electrónico " id="icon-form" class="input-group-text">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                        </div>

                        {{--  Numero de celular  --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="input-group" id="hide-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="Numero de celular: ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span title="Numero de celular" id="icon-form" class="input-group-text">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                                </div>
                            </div>
                        </div>

                        {{--  Tipo de documento  --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="input-group" id="hide-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="Tipo de documento: ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span title="Tipo de documento" id="icon-form" class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="{{ old('document_type', $user->document_type) }}">
                                </div>
                            </div>
                        </div>

                        {{--  Numero de identificacion  --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="input-group" id="hide-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="Número de identificación: ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span title="Número de identificación " id="icon-form" class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </span>
                                    <input disabled type="text" class="form-control" value="{{ old('identification_number', $user->identification_number) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end pt-4">
            <a class="btn btn-outline-secondary" style="margin-right: 2rem" href="{{route('downloadMapa')}}">Descargar mapa de navegación</a>
            @if(auth()->user()->hasRole('Administrador'))
                <a class="btn btn-outline-secondary" style="margin-right: 2rem" href="{{route('downloadManualAdmin')}}">Descargar manual de administrador</a>
            @elseif(auth()->user()->hasRole('Trabajador'))
                <a class="btn btn-outline-secondary" style="margin-right: 2rem" href="{{route('downloadManualUser')}}">Descargar manual de usuario</a>
            @endif
            <a class="btn btn-primary" style="margin-right: 2rem" href="{{ route('password.change') }}">Cambiar contraseña</a>
            <a class="btn btn-success" style="margin-right: 2rem" href="{{ route('profile.edit') }}">Editar información </a>
        </div>
    </div>
    {{-- Script  para mostrar la notificacion --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mensajeFlash = {!! json_encode(Session::get('notificacion')) !!};
            if (mensajeFlash) {
                agregarnotificacion(mensajeFlash);
            }
        });
    </script>

    {{--  Div con las notificaciones nuevas  --}}
    <div class="contenedor-notificacion" id="contenedor-notificacion">
        {{--  Aqui trae las notificaciones por medio de javaescript  --}}
    </div>

    <script src="{{ asset('js/notificaciones.js') }}" defer></script>
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
