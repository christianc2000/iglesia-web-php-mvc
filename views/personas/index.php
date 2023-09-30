<p>Lista de personas:</p>
<table>
    <thead>
        <th>CI</th>
        <th>NOMBRE</th>
        <th>APELLIDO</th>
        <th>TIPO</th>
        <th>REGISTRO</th>
        <th>OPCION</th>
    </thead>
    <tbody>
        <?php foreach ($personas as $persona) { ?>
            <tr>
                <td><?php echo $persona->ci ?></td>
                <td><?php echo $persona->nombre ?></td>
                <td><?php echo $persona->apellido; ?></td>
                <td><?php echo $persona->tipo; ?></td>
                <td><?php echo $persona->created_at; ?></td>
                <td>
                    <a href='?controller=personas&action=show&id=<?php echo $persona->id; ?>'>Editar</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>