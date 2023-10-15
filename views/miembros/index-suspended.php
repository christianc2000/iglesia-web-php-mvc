<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->
<div class="d-flex align-items-center">
    <a href="?controller=miembros&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Miembros/suspendidos</h4>
</div>
<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
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

                <?php foreach ($miembros as $miembro) { ?>
                    <tr>
                        <td><?php echo $miembro[1]->ci ?></td>
                        <td><?php echo $miembro[1]->nombre ?></td>
                        <td><?php echo $miembro[1]->apellido ?></td>
                        <td><?php echo $miembro[1]->celular ?></td>
                        <td><?php echo $miembro[1]->correo ?></td>
                        <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP',$miembro[1]->updated_at))->format('Y-m-d H:i:s'); ?></td>
                       
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href='?controller=miembros&action=delete&id=<?php echo $miembro[0]->id; ?>'>Eliminar</a></li>
                                    <li><a class="dropdown-item" href='?controller=miembros&action=enable&id=<?php echo $miembro[0]->id;?>'>Habilitar</a></li>
                                </ul>
                            </div>
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