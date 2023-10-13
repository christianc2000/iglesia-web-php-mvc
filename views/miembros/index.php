<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->
<link rel="stylesheet" href="">
<h3>Lista de Miembros</h3>
<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="pb-2">
            <a class="button-principal" href="?controller=miembros&action=create" >Registrar Miembro</a>
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>CELULAR</th>
                <th>CORREO</th>
                <th>REGISTRO</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>
                <?php foreach ($miembros as $miembro) { ?>
                    <tr>
                        <td><?php echo $miembro->id ?></td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td><?php echo $miembro->fecha_registro_miembro; ?></td>
                        <td>
                            <a href='?controller=miembros&action=show&id=<?php echo $miembro->id; ?>'>Editar</a>
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
    new DataTable('#table');
</script>