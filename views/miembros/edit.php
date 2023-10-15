<div class="d-flex align-items-center">
    <a href="?controller=miembros&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Miembros/editar/<?php echo $miembro[1]->nombre . " " . $miembro[1]->apellido?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=miembros&action=update" method="POST">
            <input type="hidden" name="id" value="<?php echo $miembro[1]->id; ?>" style="display:block">
            <div class="row g-3 px-5">
                <div class="col-md-6">
                    <label for="ci" class="form-label">CI</label>
                    <input class="form-control" type="text" name="ci" id="ci" value=<?php echo $miembro[1]->ci ?> required>
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">CORREO</label>
                    <input class="form-control" type="email" name="correo" id="correo" value=<?php echo $miembro[1]->correo ?> required>
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label">NOMBRE</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $miembro[1]->nombre ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">APELLIDO</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $miembro[1]->apellido ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="celular" class="form-label">CELULAR</label>
                    <input class="form-control" type="number" name="celular" id="celular" value=<?php echo $miembro[1]->celular ?> required>
                </div>
                <div class="col-md-6">
                    <label for="direccion" class="form-label">DIRECCION</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $miembro[1]->direccion ?>" required>
                </div>
                <div class="col-md-6">
                    
                    <label for="sexo" class="form-label">SEXO</label>
                    <select class="form-select" name="sexo" id="sexo" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="M" <?php if ($miembro[1]->sexo === "M") {
                                                echo "selected";
                                            } ?>>Masculino</option>
                        <option value="F" <?php if ($miembro[1]->sexo === "F") {
                                                echo "selected";
                                            } ?>>Femenino</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="fecha_nacimiento" class="form-label">FECHA DE NACIMIENTO</label>
                    <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value=<?php echo $miembro[1]->fecha_nacimiento ?> required>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="button-principal btn-sm">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>