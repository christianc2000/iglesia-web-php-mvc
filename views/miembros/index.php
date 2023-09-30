<p>Lista de Miembros:</p>
<a href="?controller=miembros&action=create">Registrar Miembro</a>
<table>
    <thead>
        <th>ID</th>
        <th>REGISTRO</th>
        <th>OPCION</th>
    </thead>
    <tbody>
        <?php foreach ($miembros as $miembro) { ?>
            <tr>
                <td><?php echo $miembro->id ?></td>
                <td><?php echo $miembro->fecha_registro_miembro; ?></td>
                <td>
                <a href='?controller=miembros&action=show&id=<?php echo $miembro->id; ?>'>Editar</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>