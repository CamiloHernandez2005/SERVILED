@auth

    @include('include.barra', ['modo' => 'SERVILED'])
    @can('person')
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Agregar tercero</title>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>


        </head>
        <br>
        <style>
            #box-company-name {
                display: none;
            }

            #box-first-name {
                display: none;
            }

            #box-other-name {
                display: none;
            }

            #box-surname {
                display: none;
            }

            #box-second-surname {
                display: none;
            }

            #box-comercial-name {
                display: none;
            }
        </style>

        <body>
            <div class="content container-fluid">
                <div class="page-body">
                    <div class="container-x1">
                        <div class="row row-cards">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-default">
                                        <div class="card-header d-flex">
                                            <h3 class="card-title">
                                                {{ __('Tercero') }}
                                            </h3>
                                            <div class="card-actions" style="padding-top: 9px; padding-left: 20px">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row row-cards">
                                                {{--  Rol  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="md-3 mb-3">
                                                        <label for="rol" class="form-label fw-bolder">
                                                            {{ __('Tercero') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::select('rol', ['Cliente' => 'Cliente', 'Proveedor' => 'Proveedor'], $person->rol, ['class' => 'form-select' . ($errors->has('rol') ? ' is-invalid' : ''), 'placeholder' => 'Seleciona una opción']) }}
                                                        {!! $errors->first('rol', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>

                                                {{--  Tipo de identificacion  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="md-3 mb-3">
                                                        <label for="identification_type" class="form-label fw-bolder">
                                                            {{ __('Tipo de identificación') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::select('identification_type', ['CC' => 'Cédula de Ciudadanía', 'CE' => 'Cédula de Extranjería', 'DIE' => 'Documento de Identificación Extranjero', 'NIT' => 'NIT', 'NITO' => 'NIT de otro pais', 'NUIP' => 'NUIP', 'PP' => 'Pasaporte', 'PEP' => 'Permiso especial de permanencia', 'RC' => 'Registro civil', 'TE' => 'Tarjeta de extranjeria', 'TI' => 'Tarjeta de identidad'], $person->identification_type, ['class' => 'form-select' . ($errors->has('identification_type') ? ' is-invalid' : ''), 'placeholder' => 'Seleciona una opción']) }}
                                                        {!! $errors->first(
                                                            'identification_type',
                                                            '<div class="invalid-feedback d-block">:message</div>',
                                                        ) !!}
                                                    </div>
                                                </div>

                                                {{--  Numero de identificacion   --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="identification_number" class="form-label fw-bolder" id="identification_number">
                                                            {{ __('Número de identificación') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::number('identification_number', $person->identification_number, ['id' => 'identification_number1', 'class' => 'form-control' . ($errors->has('identification_number') ? ' is-invalid' : ''), 'placeholder' => 'Número de identificación']) }}
                                                        {!! $errors->first(
                                                            'identification_number',
                                                            '<div class="invalid-feedback d-block">:message</div>',
                                                        ) !!}
                                                    </div>
                                                </div>

                                                {{--  Digito de verificacion (solo aplica para NIT)  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="digit_verification1" class="form-label fw-bolder">
                                                            {{ __('Dígito de verificación') }}
                                                            <span class="text-danger">*</span>
                                                            <span class="badge bg-secondary ms-1"><i class="fa-solid fa-lock"></i> Solo lectura</span>
                                                        </label>
                                                        {{ Form::number('digit_verification', $person->digit_verification, ['id' => 'digit_verification1', 'class' => 'form-control bg-light' . ($errors->has('digit_verification') ? ' is-invalid' : ''), 'placeholder' => 'Se calcula automáticamente', 'readonly' => 'readonly', 'tabindex' => '-1', 'style' => 'cursor: not-allowed; pointer-events: none; user-select: none;']) }}
                                                        <small class="text-muted">Se calcula automáticamente a partir del NIT.</small>
                                                        {!! $errors->first(
                                                            'digit_verification',
                                                            '<div class="invalid-feedback d-block">:message</div>',
                                                        ) !!}
                                                    </div>
                                                </div>
                                                {{--  Script para sacar el digito de verificacion  --}}
                                                <script src="{{ asset('js/formularios_digito_de_verificacion.js') }}"></script>

                                                {{--  Tipo de persona  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="person_type" class="form-label fw-bolder">
                                                            {{ __('Tipo de tercero') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::select('person_type', ['Persona natural' => 'Persona natural', 'Persona jurídica' => 'Persona jurídica'], $person->person_type, ['id' => 'person_type', 'class' => 'form-select' . ($errors->has('person_type') ? ' is-invalid' : ''), 'placeholder' => 'Seleciona una opción']) }}
                                                        {!! $errors->first('person_type', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>


                                                {{--  Nombre de compañia  --}}
                                                <div class="col-sm-6 md-6" id="box-company-name">
                                                    <div class="mb-3">
                                                        <label for="company_name" class="form-label fw-bolder">
                                                            {{ __('Razon social') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('company_name', $person->company_name, ['id' => 'company_name', 'class' => 'form-control' . ($errors->has('company_name') ? ' is-invalid' : ''), 'placeholder' => 'Razón social']) }}
                                                        {!! $errors->first('company_name', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>

                                                {{--  Nombre de comercial  --}}
                                                <div class="col-sm-6 md-6" id="box-comercial-name">
                                                    <div class="mb-3">
                                                        <label for="comercial_name" class="form-label fw-bolder">
                                                            {{ __('Nombre comercial') }}
                                                        </label>
                                                        {{ Form::text('comercial_name', $person->comercial_name, ['class' => 'form-control' . ($errors->has('comercial_name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre comercial']) }}
                                                        {!! $errors->first(
                                                            'comercial_name',
                                                            '<div class="invalid-feedback d-block">:message</div>',
                                                        ) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-cards">
                                                {{--  Primer Nombre  --}}
                                                <div class="col-sm-6 md-6" id="box-first-name">
                                                    <div class="mb-3">
                                                        <label for="first_name" class="form-label fw-bolder">
                                                            {{ __('Primer nombre') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('first_name', $person->first_name, ['class' => 'form-control' . ($errors->has('first_name') ? ' is-invalid' : ''), 'placeholder' => 'Primer nombre']) }}
                                                        {!! $errors->first('first_name', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>

                                                {{--  Segundo nombre   --}}
                                                <div class="col-sm-6 md-6" id="box-other-name">
                                                    <div class="mb-3">
                                                        <label for="other_name" class="form-label fw-bolder">
                                                            {{ __('Otro nombre') }}
                                                        </label>
                                                        {{ Form::text('other_name', $person->other_name, ['class' => 'form-control' . ($errors->has('other_name') ? ' is-invalid' : ''), 'placeholder' => 'Otro nombre']) }}
                                                        {!! $errors->first('other_name', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>

                                                {{--  Apellido   --}}
                                                <div class="col-sm-6 md-6" id="box-surname">
                                                    <div class="mb-3">
                                                        <label for="surname" class="form-label fw-bolder">
                                                            {{ __('Apellido') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('surname', $person->surname, ['class' => 'form-control' . ($errors->has('surname') ? ' is-invalid' : ''), 'placeholder' => 'Primer apellido']) }}
                                                        {!! $errors->first('surname', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>

                                                {{--  Segundo apellido  --}}
                                                <div class="col-sm-6 md-6" id="box-second-surname">
                                                    <div class="mb-3">
                                                        <label for="second_surname" class="form-label fw-bolder">
                                                            {{ __('Segundo Apellido') }}
                                                        </label>
                                                        {{ Form::text('second_surname', $person->second_surname, ['class' => 'form-control' . ($errors->has('second_surname') ? ' is-invalid' : ''), 'placeholder' => 'Segundo apellido']) }}
                                                        {!! $errors->first(
                                                            'second_surname',
                                                            '<div class="invalid-feedback d-block">:message</div>',
                                                        ) !!}
                                                    </div>
                                                </div>
                                                {{--  Ciudad  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="municipality" class="form-label fw-bolder">
                                                            {{ __('Ciudad') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="municipality_id" id="municipality_id" class="form-control selectpicker show-tick CiudadPerson" data-live-search="true" data-dropup-auto="false" title="Selecciona la ciudad" data-size='4'>
                                                            @foreach ($municipalities as $municipality)
                                                                <option value="{{ $municipality->id }}" {{ $municipality->id == $person->municipality_id ? 'selected' : '' }}>
                                                                    {{ $municipality->name }}, {{ $municipality->department->name }}, {{ $municipality->department->country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('municipality_id')
                                                            <small class="text-danger">{{ '*' . $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{--  Direccion  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label fw-bolder">
                                                            {{ __('Dirección') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('address', $person->address, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'placeholder' => 'Dirección']) }}
                                                        {!! $errors->first('address', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>

                                                {{--  Correo electronico  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="email_address" class="form-label fw-bolder">
                                                            {{ __('Correo electrónico') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::text('email_address', $person->email_address, ['class' => 'form-control' . ($errors->has('email_address') ? ' is-invalid' : ''), 'placeholder' => 'Correo electrónico']) }}
                                                        {!! $errors->first(
                                                            'email_address',
                                                            '<div class="invalid-feedback d-block">:message</div>',
                                                        ) !!}
                                                    </div>
                                                </div>

                                                {{--  Número de celular  --}}
                                                <div class="col-sm-6 md-6">
                                                    <div class="mb-3">
                                                        <label for="phone" class="form-label fw-bolder">
                                                            {{ __('Número telefónico') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{ Form::number('phone', $person->phone, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'placeholder' => 'Número telefónico']) }}
                                                        {!! $errors->first('phone', '<div class="invalid-feedback d-block">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            @if($table === 'supplier')
                                            <a class="btn btn-primary" href="{{ route('supplier.index') }}">Regresar</a>
                                            @elseif ($table === 'customer')
                                            <a class="btn btn-primary" href="{{ route('customer.index') }}">Regresar</a>
                                            @elseif($table === 'person')
                                            <a class="btn btn-primary" href="{{ route('person.index') }}">Regresar</a>
                                            @endif
                                            <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


{{--  Script para escojer el tipo de persona  --}}
<script>
    $(document).ready(function() {
        $('#person_type').on('change', function() {
            let selectValue = $(this).val();
            //Escoger los valores de natural o juridica
            if (selectValue == 'Persona natural') {
                $('#box-company-name').hide();
                $('#box-first-name').show();
                $('#box-other-name').show();
                $('#box-surname').show();
                $('#box-second-surname').show();
                $('#box-comercial-name').show();
            } else {
                $('#box-first-name').hide();
                $('#box-other-name').hide();
                $('#box-surname').hide();
                $('#box-second-surname').hide();
                $('#box-comercial-name').hide();
                $('#box-company-name').show();
            }
        });

        // Mostrar u ocultar elementos según el valor seleccionado al cargar la página
        initialSelectValue = $('#person_type').val();
        if (initialSelectValue == 'Persona natural') {
            $('#box-company-name').hide();
            $('#box-first-name').show();
            $('#box-other-name').show();
            $('#box-surname').show();
            $('#box-second-surname').show();
            $('#box-comercial-name').show();

        } else if (initialSelectValue == 'Persona jurídica') {
            $('#box-first-name').hide();
            $('#box-other-name').hide();
            $('#box-surname').hide();
            $('#box-second-surname').hide();
            $('#box-comercial-name').hide();
            $('#box-company-name').show();
        } else {
            $('#box-first-name').hide();
            $('#box-other-name').hide();
            $('#box-surname').hide();
            $('#box-second-surname').hide();
            $('#box-comercial-name').hide();
            $('#box-company-name').hide();
        }
    });
</script>
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
