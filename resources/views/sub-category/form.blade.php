@auth
    @can('categorySub')
        <div class="box box-info padding-1">
            <div class="box-body">

                <div class="form-group mb-3">
                    <label for="name" class="form-label fw-bolder">
                        {{ __('Nombre de la Subcategoría') }}
                        <span class="text-danger">*</span>
                    </label>
                    {{ Form::text('name', $subCategory->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre de la Subcategoría']) }}
                    {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="form-label fw-bolder">
                        {{ __('Descripción') }}
                        <span class="text-danger">*</span>
                    </label>
                    {{ Form::text('description', $subCategory->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Breve descripción']) }}
                    {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="box-footer mt20">
                <a class="btn btn btn-primary" href="{{ route('categorySub.index') }}">Regresar</a>
                <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
            </div>
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
