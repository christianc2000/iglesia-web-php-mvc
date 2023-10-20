<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=actividads&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Miembros/Actividad/<?php echo $actividad->nombre ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=actividads&action=storeAsistencia" method="POST">
            <input type="hidden" name="actividad_id" id="actividad_id" value="<?php echo $actividad->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="miembro" class="form-label">Miembro</label>
                    <select name="persona_id" id="persona_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($miembros as $m) { ?>
                            <option value=<?php echo $m[1]->id ?>><?php echo $m[1]->ci . " - " . $m[1]->nombre . " " . $m[1]->apellido ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 pt-4">
                    <button class="button-principal w-100" type="submit">Marcar asistencia</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th>MIEMBRO</th>
                    <th>HORA LLEGADA</th>
                    <th>REGISTRADO</th>
                    <th>ACTUALIZADO</th>
                </thead>
                <tbody>
                    <?php foreach ($asistencias as $asistencia) { ?>

                        <tr>
                            <td><?php echo $asistencia[1] . " " . $asistencia[2] ?></td>
                            <td><?php echo $asistencia[0]->horallegada ?></td>
                            <td><?php echo $asistencia[0]->created_at ?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $asistencia[0]->updated_at))->format('Y-m-d H:i:s'); ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pt-4">

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