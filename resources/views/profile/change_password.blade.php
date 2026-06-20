@auth
<head>
    <link href="{{asset('css/estilos_configuracion.css')}}" rel="stylesheet">
    <link href="{{asset('css/estilos_notificacion.css')}}" rel="stylesheet" />
    <script src="{{ asset('js/notificaciones.js')}}" defer></script>
</head>
    @include('include.barra', ['modo' => 'Cambiar contraseña'])
    @can('profile')
    <div class="bread_crumb">
        {{ Breadcrumbs::render('profile.password') }}
    </div>
    <br>
    <div class="content container-fluid">
        <div class="page-body">
            <div class="container-x1">
                <div class="row row-cards">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Cambiar contraseña
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('password.update')}}" method="POST">
                                        @csrf
                                        {{--  Contraseña actual  --}}
                                        <div class="row row-cards">
                                            <div class="col-sm-6 md-6">
                                                <div class="md-3 mb-3">
                                                    <label for="current_password" class="form-label fw-bolder">
                                                        Contraseña actual:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input_contraseña_confirmar">
                                                        <input type="password" id="password" name="current_password" required class="form-control">
                                                        <i class="formulario__icono-toggle fa-solid fa-eye-slash ojo_contrasena" id="togglePassword" onclick="togglePassword()"></i>
                                                    </div>
                                                    @error('current_password')
                                                            <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Nueva contraseña  --}}
                                        <div class="row row-cards">
                                            <div class="col-sm-6 md-6">
                                                <div class="md-3 mb-3">
                                                    <label for="new_password" class="form-label fw-bolder">
                                                        Nueva contraseña:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input_nueva_contraseña">
                                                        <input type="password" id="Newpassword" name="new_password" required class="form-control">
                                                        <i class="formulario__icono-toggle fa-solid fa-eye-slash ojo_contrasena" id="togglePasswordNew" onclick="togglePasswordNew()"></i>
                                                    </div>
                                                    @error('new_password')
                                                            <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Confirmar contraseña  --}}
                                        <div class="row row-cards">
                                            <div class="col-sm-6 md-6">
                                                <div class="md-3 mb-3">
                                                    <label for="new_password_confirmation" class="form-label fw-bolder">
                                                        Confirmar nueva contraseña:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input_confirmar_contraseña">
                                                        <input type="password" id="NewpasswordConfirm" name="new_password_confirmation" required class="form-control">
                                                        <i class="formulario__icono-toggle fa-solid fa-eye-slash ojo_contrasena" id="togglePasswordNewConfir" onclick="togglePasswordNewConfir()"></i>
                                                    </div>
                                                    @error('new_password_confirmation')
                                                            <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer text-end">
                                    <a class="btn btn-primary" href="{{ route('profile.index') }}">Regresar</a>
                                    <button type="submit" class="btn btn-success">{{ __('Cambiar contraseña') }}</button>
                                </div>
                                <script src="{{ asset('js/forActualizarEye.js') }}"></script>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
