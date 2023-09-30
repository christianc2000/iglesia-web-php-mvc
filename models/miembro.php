<?php

class Miembro
{
    public $id;
    public $fecha_registro_miembro;
    public $created_at;
    public $updated_at;
    public function __construct($id, $fecha_registro_miembro, $created_at, $updated_at)
    {

        $this->id = $id;
        $this->fecha_registro_miembro = $fecha_registro_miembro;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM miembros');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $miembro) {
            $list[] = new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
        }

        return $list;
    }
    public static function find($id)
    {
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM miembros WHERE id = :id');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        $miembro = $req->fetch();

        return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }

    public static function create($ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // CREAR A LA PERSONA
            $estado = true;
            $tipo = 'M';

            $query = 'INSERT INTO personas (ci, nombre, apellido, celular, direccion, correo, estado, tipo, sexo, fecha_nacimiento) VALUES (:ci, :nombre, :apellido, :celular, :direccion, :correo, :estado, :tipo, :sexo, :fecha_nacimiento)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':ci', $ci);
            $req_persona->bindParam(':nombre', $nombre);
            $req_persona->bindParam(':apellido', $apellido);
            $req_persona->bindParam(':celular', $celular);
            $req_persona->bindParam(':direccion', $direccion);
            $req_persona->bindParam(':correo', $correo);
            $req_persona->bindParam(':estado', $estado);
            $req_persona->bindParam(':tipo', $tipo);
            $req_persona->bindParam(':sexo', $sexo);
            $req_persona->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $req_persona->execute();

            // OBTENER EL ID DE LA PERSONA CREADA
            $persona_id = $db->lastInsertId();

            // CREAR AL MIEMBRO CON EL ID DE LA PERSONA
            $fecha_registro_miembro = 'NOW()'; // Utilizamos la fecha y hora actual
            $query = 'INSERT INTO miembros (id, fecha_registro_miembro) VALUES (:id, :fecha_registro_miembro)';
            $req_miembro = $db->prepare($query);

            $req_miembro->bindParam(':id', $persona_id);
            $req_miembro->bindParam(':fecha_registro_miembro', $fecha_registro_miembro);
            $req_miembro->execute();

            // Confirmar la transacción
            $db->commit();

            // Obtener y retornar la persona y el miembro creados
            $persona = self::find($persona_id); // Suponiendo que tienes un método find para obtener una persona por su ID
            $miembro = Miembro::find($persona_id); // Suponiendo que tienes un método find para obtener un miembro por su ID

            return ['persona' => $persona, 'miembro' => $miembro];
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
}
