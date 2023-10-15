<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<h4>Visitantes</h4>
<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="pb-2">
            <a class="button-principal" href="?controller=visitantes&action=create">Registrar Visitante</a>
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>CI</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>CELULAR</th>
                <th>CORREO</th>
                <th>ACTUALIZADO</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>

                <?php foreach ($visitantes as $visitante) { ?>
                    <tr>
                        <td><?php echo $visitante[1]->ci ?></td>
                        <td><?php echo $visitante[1]->nombre ?></td>
                        <td><?php echo $visitante[1]->apellido ?></td>
                        <td><?php echo $visitante[1]->celular ?></td>
                        <td><?php echo $visitante[1]->correo ?></td>
                        <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP',$visitante[1]->updated_at))->format('Y-m-d H:i:s'); ?></td>
                        <td>
                            <a class="btn btn-secondary" href='?controller=visitantes&action=edit&id=<?php echo $visitante[0]->id; ?>'>Editar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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