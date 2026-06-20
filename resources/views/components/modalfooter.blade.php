</div>
<div class="modal-footer">
  <button type="button" class="btn btn-success" data-bs-dismiss="modal" wire:click='limpiar("{{ $Id }}")'>Cerrar</button>
  <button type="submit" class="btn btn-primary"  @if($Id==0) wire:click='store' @else wire:click='update("{{ $Id }}")' @endif>Guardar</button>
</div>
</div>
</div>
</div>