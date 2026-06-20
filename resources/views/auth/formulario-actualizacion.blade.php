<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/7604ee3851.js" crossorigin="anonymous"></script>
        <link href="{{ asset('css/estilos_actualizar_contraseña.css')}}" rel="stylesheet"/>
        <title>Recuperacion de contraseña</title>
    </head>
    <body>

    <div class="blur">
        <div class="formulario_email">
            <div class="img_tory">
                <img src="{{ asset('img/logo.png')}}" alt="logo SERVILED" />
            </div>
            <h2>Recuperar contraseña</h2>
            <hr class="linea">
                <form action="{{ route('actualizar-contrasenia') }}" method="POST">
                @csrf
                <p>Por favor completa los campos para cambiar tu contraseña.</p>
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email_address">Email
                        <span class="text-danger">*</span>
                    </label>
                    <div>
                        <input type="text" id="email_address"  name="email" required autofocus >
                        <!-- If para la seleccion del correo electronico -->
                        @if ($errors->has('email'))
                        <div class="mesaje_eror_email">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="password">Contraseña
                        <span class="text-danger">*</span>
                    </label>
                    <div>
                        <div class="input_contrasena">
                            <input type="password" id="password" name="password" required autofocus>
                            <i class="fa-solid fa-eye-slash ojo_contrasena1" id="togglePassword" onclick="togglePassword()"></i>
                        </div>
                        <!-- If para la contraseña -->
                        @if ($errors->has('password'))
                        <div class="mesaje_eror_password">
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="password-confirm">Confirmar Contraseña
                        <span class="text-danger">*</span>
                    </label>
                    <div>
                        <div class="input_confir_contra">
                            <input type="password" id="password-confirm" name="password_confirmation" required autofocus>
                            <i class="formulario__icono-toggle fa-solid fa-eye-slash ojo_contrasena2" id="togglePassword2" onclick="togglePassword2()"></i>
                        </div>
                        <!-- If para la confirmacion de la contraseña -->
                        @if ($errors->has('password_confirmation'))
                        <div class="mesaje_eror_confirmPassword">
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <button type="submit">
                        Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/forActualizarEye.js') }}"></script>
    </body>
</html>
