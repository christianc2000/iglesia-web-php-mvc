<?php
require_once('persona.php');
require_once('miembro.php');

class HistorialMinisterio
{
    public $id;
    public $estado;
    public $cargo;
    public $miembro_id;

    public $ministerio_id;
    public $fecha_finalizado;
    public $created_at;
    public $updated_at;

    public function __construct($id, $estado, $cargo, $miembro_id, $ministerio_id, $fecha_finalizado, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->estado = $estado;
        $this->cargo = $cargo;
        $this->miembro_id = $miembro_id;
        $this->ministerio_id = $ministerio_id;
        $this->fecha_finalizado = $fecha_finalizado;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM historial_cargos ORDER BY created_at DESC');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $historial) {
            $list[] = new HistorialMinisterio($historial['id'], $historial['estado'], $historial['cargo'], $historial['miembro_id'], $historial['ministerio_id'], $historial['fecha_finalizado'], $historial['created_at'], $historial['updated_at']);
        }

        return $list;
    }

    public static function create($estado, $cargo, $miembro_id, $ministerio_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $miembroa_id = intval($miembro_id);
        $miembrob_id = intval($ministerio_id);

        try {
            // CREAR HISTORIAL CARGOS
            $query = 'INSERT INTO historial_cargos (estado, cargo, miembro_id, ministerio_id) VALUES (:estado, :cargo, :miembro_id, :ministerio_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':estado', $estado);
            $req_persona->bindParam(':cargo', $cargo);
            $req_persona->bindParam(':miembro_id', $miembro_id);
            $req_persona->bindParam(':ministerio_id', $ministerio_id);
            $req_persona->execute();
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

    public static function getMiembrosVigentesMinisterio($id) //le paso el id del ministerio
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT historial_cargos.id as historial_cargo_id, historial_cargos.estado as historial_cargos_estado, historial_cargos.fecha_finalizado, historial_cargos.created_at as historial_cargos_created_at,historial_cargos.updated_at as historial_cargos_updated_at, historial_cargos.cargo, personas.*, ministerios.id as ministerio_id, ministerios.nombre as ministerio_nombre, ministerios.descripcion, ministerios.estado as ministerio_estado, ministerios.created_at as ministerio_created_at, ministerios.updated_at as ministerio_updated_at  FROM ministerios, historial_cargos, personas WHERE historial_cargos.ministerio_id=:id AND historial_cargos.ministerio_id=ministerios.id AND historial_cargos.miembro_id=personas.id AND historial_cargos.estado=true ORDER BY historial_cargos_created_at DESC;');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));


        foreach ($req->fetchAll() as $row) {
            $historial = new HistorialMinisterio($row['historial_cargo_id'], $row['historial_cargos_estado'], $row['cargo'], $row['id'], $row['ministerio_id'], $row['fecha_finalizado'], $row['historial_cargos_created_at'], $row['historial_cargos_updated_at']);
            //   $ministerio = new Ministerio($row['ministerio_id'], $row['ministerio_nombre'], $row['descripcion'], $row['ministerio_estado'], $row['ministerio_created_at'], $row['ministerio_updated_at']);
            $persona =  new Persona($row['id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['estado'], $row['tipo'], $row['sexo'], $row['fecha_nacimiento'], $row['created_at'], $row['updated_at']);
            $list[] = [$historial, $persona];
        }

        return $list;
    }

    public static function getMiembrosCaducadosMinisterio($id) //le paso el id del ministerio
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT historial_cargos.id as historial_cargo_id, historial_cargos.estado as historial_cargos_estado, historial_cargos.fecha_finalizado, historial_cargos.created_at as historial_cargos_created_at,historial_cargos.updated_at as historial_cargos_updated_at, historial_cargos.cargo, personas.*, ministerios.id as ministerio_id, ministerios.nombre as ministerio_nombre, ministerios.descripcion, ministerios.estado as ministerio_estado, ministerios.created_at as ministerio_created_at, ministerios.updated_at as ministerio_updated_at  FROM ministerios, historial_cargos, personas WHERE historial_cargos.ministerio_id=:id AND historial_cargos.ministerio_id=ministerios.id AND historial_cargos.miembro_id=personas.id AND historial_cargos.estado=false ORDER BY historial_cargos_created_at DESC;');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));


        foreach ($req->fetchAll() as $row) {
            $historial = new HistorialMinisterio($row['historial_cargo_id'], $row['historial_cargos_estado'], $row['cargo'], $row['id'], $row['ministerio_id'], $row['fecha_finalizado'], $row['historial_cargos_created_at'], $row['historial_cargos_updated_at']);
            //   $ministerio = new Ministerio($row['ministerio_id'], $row['ministerio_nombre'], $row['descripcion'], $row['ministerio_estado'], $row['ministerio_created_at'], $row['ministerio_updated_at']);
            $persona =  new Persona($row['id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['estado'], $row['tipo'], $row['sexo'], $row['fecha_nacimiento'], $row['created_at'], $row['updated_at']);
            $list[] = [$historial, $persona];
        }

        return $list;
    }
    public static function finalizarCargoMinisterio($id)
    {
        $db = Db::getInstance();
        $historial_id = intval($id);

        $db->beginTransaction();

        try {
            $query = 'UPDATE historial_cargos SET estado = false, fecha_finalizado=NOW() WHERE id = :historial_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':historial_id', $historial_id, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar la transacción si todo fue exitoso
            $db->commit();

            return true;
        } catch (PDOException $e) {
           
            $db->rollback();
            throw $e; 
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
