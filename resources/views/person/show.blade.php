@auth
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
@can('person')

<style>
    #box-razon-social{
        display: none;
    }
    #box-first-name{
        display: none;
    }
    #box-other-name{
        display: none;
    }
    #box-surname{
        display: none;
    }
    #box-second-surname{
        display: none;
    }

    #box-comercial-name{
        display: none;
    }
</style>
@if ($table === 'supplier')
    <div class="bread_crumb">
        {{ Breadcrumbs::render('supplier.show', $person) }}
    </div>
@elseif ($table === 'customer')
    <div class="bread_crumb">
        {{ Breadcrumbs::render('customer.show', $person) }}
    </div>
@elseif($table === 'person')
    <div class="bread_crumb">
        {{ Breadcrumbs::render('person.show', $person) }}
    </div>
@endif
<br>
@include('include.barra', ['modo'=>'SERVILED'])
<section class="content container-fluid">
    <div class="page-body">
        <div class="container-x1">
            <div class="row row-cards">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{__('Visualización tercero')}}
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    {{--  Rol  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="rol" class="form-label fw-bolder">
                                                    {{ __('Tercero') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{ $person->rol }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="identification_type" class="form-label fw-bolder">
                                                    {{ __('Tipo de identificación') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{ $person->identification_type }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="identification_number" class="form-label fw-bolder">
                                                    {{ __('Numero de identificación') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{ $person->identification_number }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3" >
                                                <label for="person_type" class="form-label fw-bolder">
                                                    {{ __('Tipo de persona') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{ $person->person_type }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6" id="box-razon-social">
                                            <div class="mb-3">
                                                <label for="company_name" class="form-label fw-bolder">
                                                    {{ __('Razón social') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{ $person->company_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6"  id="box-comercial-name">
                                            <div class="mb-3">
                                                <label for="comercial_name" class="form-label fw-bolder">
                                                    {{ __('Nombre comercial')}}

                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{ $person->comercial_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6" id="box-first-name">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label fw-bolder">
                                                    {{ __('Primer nombre') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->first_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6" id="box-other-name">
                                            <div class="mb-3">
                                                <label for="other_name" class="form-label fw-bolder">
                                                    {{ __('Otro nombre') }}

                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->other_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6" id="box-surname">
                                            <div class="mb-3">
                                                <label for="surname" class="form-label fw-bolder">
                                                    {{ __('Apellido') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->surname}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6" id="box-second-surname">
                                            <div class="mb-3">
                                                <label for="second_surname" class="form-label fw-bolder">
                                                    {{ __('Segundo apellido') }}

                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->second_surname}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="digit_verification" class="form-label fw-bolder">
                                                    {{ __('DV') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->digit_verification}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="email_address" class="form-label fw-bolder">
                                                    {{ __('Correo electrónico') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->email_address}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="municipality_id" class="form-label fw-bolder">
                                                    {{ __('Ciudad') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->municipality->name}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label fw-bolder">
                                                    {{ __('Dirección') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->address}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label fw-bolder">
                                                    {{ __('Celular') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="rol" value="{{$person->phone}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label fw-bolder">
                                                    {{ __('Estado') }}
                                                    <span class="text-info">*</span>
                                                </label>
                                                @if($person->status == True)
                                                <input type="text" class="form-control" id="rol" value="Activo" readonly>
                                                @else
                                                <input type="text" class="form-control" id="rol" value="Inactivo" readonly>
                                                @endif
                                                {{--  <input type="text" class="form-control" id="rol" value="{{$person->status}}" readonly>  --}}
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                @if($table === 'supplier')
                                    <a class="btn btn-primary" href="{{ route('supplier.index') }}">Regresar</a>
                                @elseif ($table === 'customer')
                                    <a class="btn btn-primary" href="{{ route('customer.index') }}">Regresar</a>
                                @elseif ($table === 'person')
                                <a class="btn btn-primary" href="{{ route('person.index') }}">Regresar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    {{--  Script para escojer el tipo de persona  --}}
<script>
    $(document).ready(function(){
            // Función para mostrar u ocultar campos según el tipo de persona
        function mostrarOcultarCampos(selectValue) {
            if(selectValue == 'Persona natural'){
                $('#box-razon-social').hide();
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
                $('#box-razon-social').show();
            }
        }

        // Obtener el valor del tipo de persona
        let selectValue = '{{ $person->person_type }}';

        // Mostrar u ocultar campos según el tipo de persona
        mostrarOcultarCampos(selectValue);
    });

</script>

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
