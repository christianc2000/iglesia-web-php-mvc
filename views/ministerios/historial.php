<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=miembros&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Ministerios/encargados/<?php echo $ministerio->nombre; ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=ministerios&action=storeEncargado" method="POST">
            <input type="hidden" name="id" id="id" value="<?php echo $ministerio->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="miembro" class="form-label">Miembro</label>
                    <select name="miembro_id" id="miembro_id" class="form-control" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($miembros as $m) { ?>
                            <option value=<?php echo $m[1]->id ?>><?php echo $m[1]->ci . " - " . $m[1]->nombre . " " . $m[1]->apellido ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input class="form-control" type="text" name="cargo" id="cargo" required>
                </div>
                <div class="col-md-4 pt-4">
                    <button class="button-principal w-100" type="submit">Agregar</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <h4>ENCARGADOS VIGENTES</h4>
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th>ID</th> <!-- ID DEL HISTORIAL_CARGO -->
                    <th>CARGO</th> <!-- CARGO DEL HISTORIAL_CARGO -->
                    <th>CI</th>
                    <th>MIEMBRO</th> <!-- NOMBRE Y APELLIDO DEL MIEMBRO QUE ESTÁ A CARGO DE ESE MINISTERIO -->
                    <th>REGISTRO</th>
                    <th>OPCIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($historialv_ministerio as $historialv) { ?>
                        <tr>
                            <td><?php echo $historialv[0]->id ?></td>
                            <td><?php echo $historialv[0]->cargo ?></td>
                            <td><?php echo $historialv[1]->ci ?></td>
                            <td><?php echo $historialv[1]->nombre . " " . $historialv[1]->apellido ?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $historialv[0]->created_at))->format('Y-m-d H:i:s'); ?></td>
                            <td>
                                <form action="?controller=ministerios&action=finalizarCargoMinisterio" method="POST">
                                    <input type="hidden" name="ministerio_id" id="ministerio_id" value="<?php echo $historialv[0]->ministerio_id; ?>" style="display:block">
                                    <input type="hidden" name="historial_id" id="historial_id" value="<?php echo $historialv[0]->id; ?>" style="display:block">
                                    <button type="submit" class="btn btn-dark">Finalizar Cargo</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            <h4>ENCARGADOS NO VIGENTES</h4>
            <table class="table table-striped col-md-12" id="table2" style="width:100%">
                <thead>
                    <th>ID</th> <!-- ID DEL HISTORIAL_CARGO -->
                    <th>CARGO</th> <!-- CARGO DEL HISTORIAL_CARGO -->
                    <th>CI</th>
                    <th>MIEMBRO</th> <!-- NOMBRE Y APELLIDO DEL MIEMBRO QUE ESTÁ A CARGO DE ESE MINISTERIO -->
                    <th>REGISTRO</th>
                    <th>FINALIZACIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($historialc_ministerio as $historialc) { ?>
                        <tr>
                            <td><?php echo $historialc[0]->id ?></td>
                            <td><?php echo $historialc[0]->cargo ?></td>
                            <td><?php echo $historialc[1]->ci ?></td>
                            <td><?php echo $historialc[1]->nombre." ".$historialc[1]->apellido?></td>
                            <td class="m-1" style="background-color: #0FFFC8;font-weight: 700;"><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $historialc[0]->created_at))->format('Y-m-d H:i:s'); ?></td>
                            <td class="m-1" style="background-color: #D3C35F;font-weight: 700;"><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $historialc[0]->fecha_finalizado))->format('Y-m-d H:i:s'); ?></td>
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