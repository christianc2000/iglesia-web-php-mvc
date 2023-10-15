<div class="d-flex align-items-center">
    <a href="?controller=ministerios&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Ministerio/crear</h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=ministerios&action=store" method="POST">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre">
                        <label for="nombreInput">Nombre</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Describe el ministerio" id="descripcion" name="descripcion" style="height: 100px" required></textarea>
                        <label for="descripcionInput">Descripción</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <select class="form-select" aria-label="Default select status" id="estado" name="estado">
                        <option selected disabled>Seleccione una opción</option>
                        <option value=1>HABILITAR</option>
                        <option value=0>DESHABILITAR</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="button-principal btn-sm">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>