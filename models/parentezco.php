<?php
require_once('persona.php');
require_once('miembro.php');

class Parentezco
{
    public $id;
    public $parentezco;
    public $miembroa_id;
    public $miembrob_id;
    public $created_at;
    public $updated_at;

    public function __construct($id, $parentezco, $miembroa_id, $miembrob_id, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->parentezco = $parentezco;
        $this->miembroa_id = $miembroa_id;
        $this->miembrob_id = $miembrob_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM parentezco');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $parentezco) {
            $list[] = new Parentezco($parentezco['id'], $parentezco['parentezco'], $parentezco['miembroa_id'], $parentezco['miembrob_id'], $parentezco['created_at'], $parentezco['updated_at']);
        }

        return $list;
    }

    public static function create($parentezco, $miembroa_id, $miembrob_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $miembroa_id = intval($miembroa_id);
        $miembrob_id = intval($miembrob_id);

        try {
            // CREAR PARENTEZCO
            $query = 'INSERT INTO parentezcos (parentezco, miembroa_id, miembrob_id) VALUES (:parentezco, :miembroa_id, :miembrob_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':parentezco', $parentezco);
            $req_persona->bindParam(':miembroa_id', $miembroa_id);
            $req_persona->bindParam(':miembrob_id', $miembrob_id);
            $req_persona->execute();

            // Obtener y retornar el ID del último registro insertado
            $ultimoInsertId = $db->lastInsertId();

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            echo $e;
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }

    public static function getMiembroParentezco($id)
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT parentezcos.*, personas.ci, personas.nombre, personas.apellido, personas.fecha_nacimiento, personas.sexo, personas.celular, personas.direccion, personas.correo, personas.estado, personas.tipo, personas.created_at, personas.updated_at FROM parentezcos, personas WHERE parentezcos.miembroa_id=:id AND parentezcos.miembrob_id=personas.id ORDER BY parentezcos.id DESC;');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));


        foreach ($req->fetchAll() as $row) {
            $parentezcos = new Parentezco($row['id'], $row['parentezco'], $row['miembroa_id'], $row['miembrob_id'], $row['created_at'], $row['updated_at']);
            $personas = new Persona($row['miembrob_id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['estado'], $row['tipo'], $row['sexo'], $row['fecha_nacimiento'], $row['created_at'], $row['updated_at']);
            $list[] = [$parentezcos, $personas];
        }

        return $list;
    }

    public static function getMiembroParentezcoRelacionados($id)
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT parentezcos.*, personas.ci, personas.nombre, personas.apellido, personas.fecha_nacimiento, personas.sexo, personas.celular, personas.direccion, personas.correo, personas.estado, personas.tipo, personas.created_at, personas.updated_at FROM parentezcos, personas WHERE parentezcos.miembrob_id=:id AND parentezcos.miembroa_id=personas.id ORDER BY parentezcos.id DESC;');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));


        foreach ($req->fetchAll() as $row) {
            $parentezcos = new Parentezco($row['id'], $row['parentezco'], $row['miembroa_id'], $row['miembrob_id'], $row['created_at'], $row['updated_at']);
            $personas = new Persona($row['miembrob_id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['estado'], $row['tipo'], $row['sexo'], $row['fecha_nacimiento'], $row['created_at'], $row['updated_at']);
            $list[] = [$parentezcos, $personas];
        }

        return $list;
    }
    public static function delete($id)
    {
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $parentezco_id = intval($id);

        // Comenzar una transacción para asegurar la integridad de los datos
        $db->beginTransaction();

        try {
            // Primero, eliminamos el parentezco
            $query = 'DELETE FROM parentezcos WHERE id = :parentezco_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':parentezco_id', $parentezco_id, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar la transacción si todo fue exitoso
            $db->commit();

            return true; // Éxito, el parentezco fue eliminado
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción y manejar el error
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        // Asegurémonos de que $id sea un entero
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM parentezcos WHERE parentezcos.id = :id');
        // La consulta ha sido preparada, ahora reemplazamos :id con el valor actual de $id
        $req->execute(array('id' => $id));

        // Comprobamos si se encontraron resultados
        $row = $req->fetch();

        if (!$row) {
            // No se encontraron resultados, puedes manejarlo de acuerdo a tus necesidades
            return null;
        }

        // Devolvemos los datos del parentezco que coincidió con el ID
        return new Parentezco($row['id'], $row['parentezco'], $row['miembroa_id'], $row['miembrob_id'], $row['created_at'], $row['updated_at']);
    }
}
