<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<h4>Ministerios</h4>
<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="pb-2">
            <a class="button-principal" href="?controller=ministerios&action=create">Crear Ministerio</a>
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>ESTADO</th>
                <th>ACTUALIZADO</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>

                <?php foreach ($ministerios as $ministerio) { ?>
                    <tr>
                        <td><?php echo $ministerio->id ?></td>
                        <td><?php echo $ministerio->nombre ?></td>
                        <td class="p-2" style="align-items: center;">
                            <?php if ($ministerio->estado) { ?>
                                <div style="background-color: #0FFFC8;font-weight: 700; text-align: center; margin: 5px; border-radius: 10px;">
                                    HABILITADO
                                </div>
                            <?php } else { ?>
                                <div style="background-color: #241910; color:white;font-weight: 700; text-align: center; margin: 5px; border-radius: 10px;">
                                    DESHABILITADO
                                </div>
                            <?php } ?>
                        </td>
                        <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $ministerio->updated_at))->format('Y-m-d H:i:s'); ?></td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href='?controller=ministerios&action=show&id=<?php echo $ministerio->id;?>'>Ver</a></li>
                                    <li><a class="dropdown-item" href='?controller=ministerios&action=edit&id=<?php echo $ministerio->id;?>'>Editar</a></li>
                                    <li><a class="dropdown-item" href='?controller=ministerios&action=historialEncargadosMinisterio&id=<?php echo $ministerio->id;?>'>Encargados</a></li>
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