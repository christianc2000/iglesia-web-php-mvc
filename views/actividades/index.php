<!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Contenido -->
<h4>Actividades</h4>
<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="pb-2">
            <a class="button-principal" href="?controller=actividades&action=create">Crear Actividad</a>
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>FECHA</th>
                <th>HORA INICIO</th>
                <th>HORA FIN</th>
                <th>MONTO TOTAL</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>
                <?php foreach ($actividades as $actividad) { ?>
                    <tr>
                        <td><?php echo $actividad->id ?></td>
                        <td><?php echo $actividad->nombre ?></td>
                        <td><?php echo $actividad->fecha ?></td>
                        <td><?php echo $actividad->horaInicio ?></td>
                        <td><?php echo $actividad->horaFin ?></td>
                        <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $actividad->updated_at))->format('Y-m-d H:i:s'); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href='?controller=actividads&action=show&id=<?php echo $actividad->id; ?>'>Ver</a></li>
                                    <li><a class="dropdown-item" href='?controller=actividads&action=edit&id=<?php echo $actividad->id; ?>'>Editar</a></li>
                                    <li><a class="dropdown-item" href='?controller=actividads&action=asistencia&id=<?php echo $actividad->id; ?>'>Asistencia</a></li>
                                    <!-- Puedes agregar otras opciones específicas de actividades aquí -->
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    new DataTable('#table', {
        order: []
    });
</script>