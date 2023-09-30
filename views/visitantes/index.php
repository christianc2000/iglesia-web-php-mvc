<p>Lista de Visitantes:</p>
<a href="?controller=visitantes&action=create">Registrar Visitante</a>
<table>
    <thead>
        <th>ID</th>
        <th>REGISTRO</th>
        <th>OPCION</th>
    </thead>
    <tbody>
        <?php foreach ($visitantes as $visitante) { ?>
            <tr>
                <td><?php echo $visitante->id ?></td>
                <td><?php echo $visitante->fecha_registro_visitante; ?></td>
                <td>
                <a href='?controller=visitantes&action=show&id=<?php echo $visitante->id; ?>'>Editar</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>