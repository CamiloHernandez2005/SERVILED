@auth
@include('include.barra', ['modo'=>'Permiso de usuarios'])
<br>
@can('admin.usuarios.edit')

<div class="content container-fluid">
    <div class="page-body">
        <div class="container-x1">
            <div class="row row-cards">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default">
                            <div class="card-header d-flex">
                                <h3 class="card-title">
                                    {{ Breadcrumbs::render('admin.edit') }}
                                </h3>
                            </div>

                            {!! Form::model($usuario, ['route' => ['admin.usuarios.update', $usuario->id], 'method' => 'put']) !!}
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-sm-6 md-6">
                                        <div class="md-3 mb-3">
                                            <label class="form-label fw-bolder">
                                                Usuario:
                                            </label>
                                            <p class="form-control">{{$usuario->name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 md-6">
                                        <div class="md-3">
                                            <label class="form-label fw-bolder">
                                                Roles:
                                            </label>
                                            <div>
                                                @foreach ($roles as $role )
                                                        {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                                                        {{$role->name}}
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="card-footer text-end container_botones">
                            <a class="btn btn-primary caja_subir" style="margin-right: 5rem" href="{{ route('admin.usuarios.index') }}">Regresar</a>
                            {!! Form::submit('Asignar rol', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
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
