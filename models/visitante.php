<?php

class Visitante
{
    public $id;
    public $fecha_registro_visitante;
    public $created_at;
    public $updated_at;
    public function __construct($id, $fecha_registro_visitante, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->fecha_registro_visitante = $fecha_registro_visitante;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM visitantes');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $visitante) {
            $list[] = new Visitante($visitante['id'], $visitante['fecha_registro_visitante'], $visitante['created_at'], $visitante['updated_at']);
        }

        return $list;
    }
    public static function find($id)
    {
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM visitantes WHERE id = :id');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        $visitante = $req->fetch();

        return new Visitante($visitante['id'], $visitante['fecha_registro_visitante'], $visitante['created_at'], $visitante['updated_at']);
    }
    public static function create($ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // CREAR A LA PERSONA
            $estado = true;
            $tipo = 'V';

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

            // CREAR AL VISITANTE CON EL ID DE LA PERSONA
            $fecha_registro_visitante = 'NOW()'; // Utilizamos la fecha y hora actual
            $query = 'INSERT INTO visitantes (id, fecha_registro_visitante) VALUES (:id, :fecha_registro_visitante)';
            $req_visitante = $db->prepare($query);

            $req_visitante->bindParam(':id', $persona_id);
            $req_visitante->bindParam(':fecha_registro_visitante', $fecha_registro_visitante);
            $req_visitante->execute();

            // Confirmar la transacción
            $db->commit();

            // Obtener y retornar la persona y el miembro creados
            $persona = self::find($persona_id); // Suponiendo que tienes un método find para obtener una persona por su ID
            $visitante = Visitante::find($persona_id); // Suponiendo que tienes un método find para obtener un miembro por su ID

            return ['persona' => $persona, 'visitante' => $visitante];
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
}
