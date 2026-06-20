<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <script src="https://kit.fontawesome.com/7604ee3851.js" crossorigin="anonymous"></script>
        <link href="css/estilos_inicio_sesion.css" rel="stylesheet" />
        <link href="css/estilos_notificacion_login.css" rel="stylesheet" />
        <script src="{{ asset('js/notificaciones.js')}}" defer></script>

        <title>SERVILED</title>
        <link rel="website icon" type="png" href="{{asset('img/logo.png')}}">
    </head>
    <body>
    <div class="img_tory">
        <img src="{{ asset('img/logo.png')}}" alt="" />
    </div>
    <!-- inicio del formulario -->
    <main>
        <div class="contenedor_todo">
            <div class="caja_trasera">
                <div class="caja-tra-login">
                <h3>¿Ya estas registrado?</h3>
                <p>Inicio sesión para entrar en la pagina</p>
                <button id="btn_iniciar_sesion">Iniciar Sesión</button>
            </div>

            <div class="caja-tra-register">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Regístrate para Iniciar sesión</p>
                <button id="btn_registrarse">Registrarse</button>
            </div>
        </div>

        <div class="contenedor_login-registro">
            <!-- Formulario para el login del usuario -->
            <form action="/login" method="POST" class="formulario_login" id="formulario">
            @csrf
            <h2>Iniciar sesión</h2>
            <hr />

            <!-- Grupo para el input de usuario -->
            <div class="formulario__grupo" id="grupo__name">
                <label for="name" class="formulario__label">Usuario
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="text"  name="name"  value="{{ old('name') }}" placeholder="Correo electronico" class="formulario__input input_inicio" id="name"/>
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Este campo debe contener un correo electronico registrado</p>
            </div>
            <br>
            <!-- Grupo del input para la contraseña -->
            <div class="formulario__grupo" id="grupo__password">
                <label for="password" class="formulario__label">Contraseña
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="password" class="formulario__input input_inicio" name="password" id="password" placeholder="Contraseña">
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                    <i class="formulario__icono-toggle fa-solid fa-eye-slash ojo_contrasena" id="togglePassword" onclick="togglePassword()"></i>
                </div>
                <p class="formulario__input-error">
                    Debe contener al menos 8 caracteres, incluyendo letras mayúsculas y minúsculas, al menos un número y un símbolo.
                </p>
            </div>

            <!-- Mensaje de aviso -->
            <div class="formulario__mensaje" id="formulario__mensaje">
                <p><i class="icon_error fa-solid fa-triangle-exclamation fa-xl"></i><b>Error: </b>Por favor complete el formulario correctamenete </p>
            </div>

            <!-- Div para el reseteo de contraseña -->
            <div class="reset_password">
                <a class="forward_password" href="{{ route('formulario-recuperar-contrasenia') }}">
                    ¿Olvidó su contraseña?
                </a>
            </div>
            <!-- Boton de envio del formulario -->
            <div class="formulario__grupo formulario__grupo-btn-enviar">
                <button type="submit" class="formulario__btn" id="btn-iniciar_sesion">Ingresar</button>
            </div>

            </form>
            <script src="js/formulario.js"></script>
            <script src="js/ocultar_mensaje.js"></script>


            <!-- Formulario para registrarse -->
            <form action="/register" method="POST" class="formulario_registro" id="formulario_registro">
            @csrf
            <h2>Registrarse</h2>
            <hr class="formulario_registro_linea" />

            <!-- Grupo para el nombre -->
            <div class="formulario__grupo" id="grupo__nombre">
                <label for="nombre" class="formulario__label">Nombre completo
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="text" name="name" class="formulario__input" placeholder="Ejemplo: Jhon Doe" id="nombre">
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">El nombre no debe de contener numeros o caracteres especiales</p>
            </div>

            <!-- Grupo para el correo electronico -->
            <div class="formulario__grupo" id="grupo__email">
                <label for="email" class="formulario__label">Correo electrónico
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="email" class="formulario__input" name="email" placeholder="Ejemplo: JhonDoe@gmail.com" id="email">
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">El correo solo puede contener letras, numeros, puntos, guiones y guin bajo.</p>
            </div>

            <!-- Grupo para el telefono -->
            <div class="formulario__grupo" id="grupo__phone_number">
                <label for="phone_number" class="formulario__label">Teléfono
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="number" class="formulario__input" placeholder="Ejemplo: 3002000" name="phone_number" id="phone_number">
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">El telefono solo puede contener numeros con una cantidad de 10 digitos</p>
            </div>

            <!-- Grupo para el tipo de documento -->
            <div class="formulario__grupo" id="grupo__documento">
                <label for="tipo_documento" class="formulario__label">Tipo de documento
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <select name="document_type" id="tipo_documento" class="formulario__input">
                        <option value="">Seleccione un tipo de documento</option>
                        <option value="CC">C.C - Cédula de ciudadanía</option>
                        <option value="TI">T.I - Tarjeta de identidad</option>
                        <option value="RC">R.C - Registro civil</option>
                        <option value="TE">T.E - Tarjeta de extaranjeria</option>
                        <option value="CE">C.E - Cedula de extranjeria</option>
                        <option value="NIT">NIT - Numero de identificacion tributaria</option>
                        <option value="PP">P.P - Pasaporte</option>
                    </select>
                </div>
                <p class="formulario__input-error">Por favor seleccione un tipo de docuemneto</p>
            </div>

            <!-- Grupo para el numero de identificacion -->
            <div class="formulario__grupo" id="grupo__identification_number">
                <label for="identification_number" class="formulario__label">Número de identificacion
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="number" class="formulario__input" name="identification_number" placeholder="Ejemplo: 1054283229" id="identification_number">
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Completa este campo</p>
            </div>

            <!-- Grupo para la contraseña -->
            <div class="formulario__grupo" id="grupo__contrasena">
                <label for="contrasena" class="formulario__label">Contraseña
                    <span class="text_red">*</span>
                </label>
                <div class="formulario__grupo-input">
                    <input type="password" class="formulario__input" name="password" id="contrasena" placeholder="********">
                    <i class="formulario__validacion-estado far fa-times-circle"></i>
                    <i class="formulario__icono-toggle fa-solid fa-eye-slash ojo_contrasena_register" id="togglePasswordRegi" onclick="togglePasswordRegister()"></i>
                </div>
                <p class="formulario__input-error">
                    Debe contener al menos 8 caracteres, incluyendo letras mayúsculas y minúsculas, al menos un número y un símbolo.
                </p>
            </div>

            <!-- Mensaje de error -->
            <div class="formulario__mensaje2" id="formulario__mensaje2">
                <p class="texto"><i class="icon_error2 fa-solid fa-triangle-exclamation fa-xl"></i><b>Error: </b>Por favor complete el formulario correctamenete </p>
            </div>

            <!-- Enviar el formulario -->
            <div class="formulario__grupo formulario__grupo-btn-enviar">
                <button type="submit" class="formulario__btn">Registrarse</button>
            </div>
            </form>
            <script src="js/formularioRegistro.js"></script>
            </div>
        </div>
    </main>
    <script src="js/script_inicio_sesion.js"></script>
    {{--  Notificacion para cuando hay errores  --}}
    @if ($errors->any())

    <div class="contenedor-notificacion" id="contenedor-notificacion">
        <div class="notificacion error" id="1">
            <div class="contenido">
                <div class="icono">
                    <svg
						xmlns="http://www.w3.org/2000/svg"
						fill="currentColor"
						viewBox="0 0 16 16">
						<path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
					</svg>
                </div>
                <div class="texto">
                    <p class="titulo">Error!</p>
                    <p class="descripcion">
                            <ul>
                                @foreach ($errors->all() as $error)
                                {{$error}}
                                @endforeach
                            </ul>
                    </p>
                </div>
            </div>
            <button class="boton-cerrar">
                <div class="icono">
                    <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </div>
            </button>
        </div>
    </div>

    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
    </body>
</html>
