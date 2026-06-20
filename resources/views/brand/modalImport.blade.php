<div class="modal fade" id="importBrands" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Importar Marca</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                <form action="{{route('importbrands')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_file" class="form-control mb-3" required>
                    <a href="{{ route('downloadFileBrands') }}" class="btn btn-warning">Descargar Plantilla</a>
                    <button class="btn btn btn-success " type="submit">Importar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>