<div class="d-flex align-items-center">
    <a href="?controller=miembros&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Miembros/ver/<?php echo $miembro[1]->nombre . " " . $miembro[1]->apellido; ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="row g-3 px-5">
            <div class="col-md-6">
                <label for="ci" class="form-label">CI</label>
                <input class="form-control" type="text" name="ci" id="ci" value="<?php echo $miembro[1]->ci; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label">CORREO</label>
                <input class="form-control" type="email" name="correo" id="correo" value="<?php echo $miembro[1]->correo; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label">NOMBRE</label>
                <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $miembro[1]->nombre; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="apellido" class="form-label">APELLIDO</label>
                <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $miembro[1]->apellido; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="celular" class="form-label">CELULAR</label>
                <input class="form-control" type="number" name="celular" id="celular" value="<?php echo $miembro[1]->celular; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="direccion" class="form-label">DIRECCION</label>
                <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $miembro[1]->direccion; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="sexo" class="form-label">SEXO</label>
                <?php if($miembro[1]->sexo=="M"){ ?>
                    <input class="form-control" type="text" name="sexo" id="sexo" value="Masculino" disabled>
                <?php }?>
                <?php if($miembro[1]->sexo=="F"){?>
                    <input class="form-control" type="text" name="sexo" id="sexo" value="Femenino" disabled>
                <?php }?>
            </div>
            <div class="col-md-6">
                <label for="fecha_nacimiento" class="form-label">FECHA DE NACIMIENTO</label>
                <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $miembro[1]->fecha_nacimiento; ?>" disabled>
            </div>
            <div class="col-md-6">
            <label for="miembro" class="form-label">DATOS COMO MIEMBRO</label>
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>REGISTRO</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $miembro[0]->id ?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP',$miembro[0]->fecha_registro_miembro))->format('Y-m-d H:i:s');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
            <label for="visitante" class="form-label">DATOS COMO VISITANTE</label>
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>REGISTRO</th>
                        <th>FINALIZACIÓN</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $visitante[0]->id?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP',$visitante[0]->fecha_registro_visitante))->format('Y-m-d H:i:s');?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP',$miembro[0]->fecha_registro_miembro))->format('Y-m-d H:i:s');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>