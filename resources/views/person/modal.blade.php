<!-- Modal -->
@foreach ( $people as $person )
<div class="modal fade" id="confirmationDestroy-{{$person->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Accion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                {{ $person->status == True ? '¿Seguro que quiere inactivar al tercero?' : '¿Seguro que quiere activar al tercero?' }}
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="{{ route('person.destroy',$person->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Confirmar</button>
        </form>

        </div>
    </div>
    </div>
</div>
@endforeach

{{--  Modal importación de datos  --}}

<div class="modal fade" id="importPerson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Importar Tercero</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>            
                <form action="{{route('importPerson')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_filePerson" class="form-control " style="margin-bottom: 2rem" required>
                    <a href="{{ route('downloadFile') }}" class="btn btn-warning">Descargar Plantilla</a>
                    <button class="btn btn btn-success" type="submit">Importar</button>
                </form>  
            </div>
        </div>
    </div>
    </div>
</div>

