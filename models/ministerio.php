<?php
require_once('persona.php'); // Reemplaza 'ruta_a_persona.php' con la ruta correcta al archivo de la clase Persona

class Ministerio
{
    public $id;
    public $nombre;
    public $descripcion;
    public $estado;
    public $created_at;
    public $updated_at;
    public function __construct($id, $nombre, $descripcion, $estado, $created_at, $updated_at)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->descripcion=$descripcion;
        $this->estado=$estado;
        $this->created_at=$created_at;
        $this->updated_at=$updated_at;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM ministerios ORDER BY updated_at DESC;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $ministerio) {
            $list[] = new Ministerio($ministerio['id'], $ministerio['nombre'], $ministerio['descripcion'], $ministerio['estado'], $ministerio['created_at'], $ministerio['updated_at']);
        }
        return $list;
    }
    
    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM ministerios WHERE id = :id');
       
        $req->execute(array('id' => $id));
        $row = $req->fetch();
        $ministerio = new Ministerio($row['id'], $row['nombre'], $row['descripcion'], $row['estado'], $row['created_at'], $row['updated_at']);

        return $ministerio;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }
    public static function update($id, $nombre, $descripcion, $estado)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // ACTUALIZAR LOS DATOS DE LA PERSONA
            $updated_at='NOW()';
            $query = 'UPDATE ministerios SET nombre = :nombre, descripcion = :descripcion, estado = :estado, updated_at=:updated_at WHERE id = :id';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':nombre', $nombre);
            $req_persona->bindParam(':descripcion', $descripcion);
            $req_persona->bindParam(':estado', $estado);
            $req_persona->bindParam(':updated_at', $updated_at);
            $req_persona->bindParam(':id', $id);
            $req_persona->execute();

            // Confirmar la transacción
            $db->commit();


            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }

    public static function create($nombre, $descripcion, $estado)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            $query = 'INSERT INTO ministerios (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado);';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':nombre', $nombre);
            $req_persona->bindParam(':descripcion', $descripcion);
            $req_persona->bindParam(':estado', $estado);
            $req_persona->execute();

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
}
