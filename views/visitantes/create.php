<div>
    <H2>Registrar nuevo Visitante</H2>
    <form action="?controller=visitantes&action=store" method="POST">
        <H3>Datos Personales</H3>
        <div>
            <label for="">CI</label>
            <input type="text" name="ci" id="ci">
        </div>
        <div>
            <label for="">NOMBRE</label>
            <input type="text" name="nombre" id="nombre">
        </div>
        <div>
            <label for="">APELLIDO</label>
            <input type="text" name="apellido" id="apellido">
        </div>
        <div>
            <label for="">CORREO</label>
            <input type="email" name="correo" id="correo">
        </div>
        <div>
            <label for="">CELULAR</label>
            <input type="number" name="celular" id="celular">
        </div>
        <div>
            <label for="">DIRECCION</label>
            <input type="text" name="direccion" id="direccion">
        </div>
        <div>
            <label for="">SEXO</label>
            <select name="sexo" id="sexo" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="M">Masculino</option>
                <option value="F">Femenido</option>
            </select>
        </div>
        <div>
            <label for="">FECHA DE NACIMIENTO</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
        </div>
        <button type="submit">Guardar</button>
    </form>
</div>