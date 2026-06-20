<!-- Modal -->
@foreach ( $subCategories as $subCategory )
<div class="modal fade" id="confirmationDestroy-{{$subCategory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Acción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                {{ $subCategory->status == 1 ? '¿Seguro que quiere inactivar el registro?' : '¿Seguro que quiere activar el registro?' }}
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
        <form action="{{ route('categorySub.destroy',$subCategory->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-primary" style="width:120px">Confirmar</button>
        </form>
        
        </div>
    </div>
    </div>
</div>
@endforeach