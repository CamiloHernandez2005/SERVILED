<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/7604ee3851.js" crossorigin="anonymous"></script>
        <link href="css/estilos_recuperar_contraseña.css" rel="stylesheet"/>
        <title>Recuperacion de contraseña</title>
        <link rel="website icon" type="png" href="{{asset('img/logo.png')}}">
    </head>
    <body>

    <div class="blur">
        <div class="formulario_email">
            <div class="img_tory">
                <img src="{{ asset('img/logo.png')}}" alt="logo SERVILED" />
            </div>
            <h2>¿Olvidaste tu contraseña?</h2>
            <hr class="linea">
            <form action="{{ route('enviar-recuperacion') }}" method="POST">
                <p>No te preocupes, te enviaremos un correo con la informacion necesaria para poder restablecerla.</p>
                @csrf
                <div>
                    <label for="email_address">Email
                        <span class="text-danger">*</span>
                    </label>
                    <br>
                        <input type="text" id="email_address" class="" name="email" required autofocus>
                        <br>
                        <br>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                </div>
                <div class="mensaje_confirmation">
                    @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                </div>
                <div>
                    <button type="submit" class="">
                        Enviar Email de recuperacion
                    </button>

                    <button class="boton_regresar">
                        <a href="/login">Regresar</a>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </body>
</html>
