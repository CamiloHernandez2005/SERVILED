<!-- Modal -->
@foreach ( $categories as $category)
<div class="modal fade" id="confirmationDestroy-{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Acción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                {{ $category->status == 1 ? '¿Seguro que quiere inactivar el registro?' : '¿Seguro que quiere activar el registro?' }}
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" wire:click='delete("{{ $category->id }}")'>Confirmar</button>
        </div>
    </div>
    </div>
</div>
@endforeach