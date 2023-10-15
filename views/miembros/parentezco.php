<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=miembros&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Miembros/parentezco/<?php echo $miembro[1]->nombre . " " . $miembro[1]->apellido; ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=miembros&action=storeParentezco" method="POST">
            <input type="hidden" name="miembroa_id" id="miembroa_id" value="<?php echo $miembro[1]->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="miembro" class="form-label">Miembro</label>
                    <select name="miembrob_id" id="miembrob_id" class="form-control" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($miembros as $m) { ?>
                            <option value=<?php echo $m[1]->id ?>><?php echo $m[1]->ci . " - " . $m[1]->nombre . " " . $m[1]->apellido ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="parentezco" class="form-label">Parentezco</label>
                    <input class="form-control" type="text" name="parentezco" id="parentezco" required>
                </div>
                <div class="col-md-4 pt-4">
                    <button class="button-principal w-100" type="submit">Agregar</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th>CI</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>PARENTEZCO</th>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>FECHA REGISTRADO</th>
                    <th>OPCIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($parentezcos as $parentezco) { ?>
                        <tr>
                            <td><?php echo $parentezco[1]->ci ?></td>
                            <td><?php echo $parentezco[1]->nombre ?></td>
                            <td><?php echo $parentezco[1]->apellido ?></td>
                            <td><?php echo $parentezco[0]->parentezco ?></td>
                            <td><?php echo $parentezco[1]->fecha_nacimiento ?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $parentezco[0]->created_at))->format('Y-m-d H:i:s'); ?></td>
                            <td>
                                <form action="?controller=miembros&action=deleteParentezco" method="POST">
                                    <input type="hidden" name="miembroa_id" id="miembroa_id" value="<?php echo $parentezco[0]->miembroa_id; ?>" style="display:block">
                                    <input type="hidden" name="parentezco_id" id="parentezco_id" value="<?php echo $parentezco[0]->id; ?>" style="display:block">
                                    <button type="submit" class="btn btn-dark">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            <h4>Parentezco Relacionados</h4>
            <table class="table table-striped col-md-12" id="table2" style="width:100%">
                <thead>
                    <th>CI</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>FECHA REGISTRADO</th>
                    <th class="text-uppercase"><?php echo $miembro[1]->nombre . " " . $miembro[1]->apellido . " RELACIONADA COMO " ?></th>
                </thead>
                <tbody>
                    <?php foreach ($parentezcos_relacionados as $parentezco) { ?>
                        <tr>
                            <td><?php echo $parentezco[1]->ci ?></td>
                            <td><?php echo $parentezco[1]->nombre ?></td>
                            <td><?php echo $parentezco[1]->apellido ?></td>
                            <td><?php echo $parentezco[1]->fecha_nacimiento ?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $parentezco[0]->created_at))->format('Y-m-d H:i:s'); ?></td>
                            <td class="m-1" style="background-color: #0FFFC8;font-weight: 700;"><?php echo $parentezco[0]->parentezco ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- js -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    new DataTable('#table', {
        order: []
    });
</script>