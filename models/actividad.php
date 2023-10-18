<?php
require_once('persona.php'); // Reemplaza 'ruta_a_persona.php' con la ruta correcta al archivo de la clase Persona

class Actividad
{
    public $id;
    public $fecha;
    public $horaInicio;
    public $horaFin;
    public $montoTotal;
    public $nombre;
    public $created_at;
    public $updated_at;
    public function __construct($id, $fecha, $horaInicio, $horaFin, $montoTotal, $nombre, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;
        $this->montoTotal = $montoTotal;
        $this->nombre = $nombre;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM actividads ORDER BY updated_at DESC;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $actividad) {
            $list[] = new Actividad($actividad['id'], $actividad['fecha'], $actividad['horainicio'], $actividad['horafin'], $actividad['montototal'], $actividad['nombre'], $actividad['created_at'], $actividad['updated_at']);
        }
        return $list;
    }

    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM actividads WHERE id = :id');

        $req->execute(array('id' => $id));
        $actividad = $req->fetch();
        $actividad =  new Actividad($actividad['id'], $actividad['fecha'], $actividad['horainicio'], $actividad['horafin'], $actividad['montototal'], $actividad['nombre'], $actividad['created_at'], $actividad['updated_at']);

        return $actividad;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }
    public static function update($id, $fecha, $horaInicio, $horaFin, $montoTotal, $nombre)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            $updated_at = date('Y-m-d H:i:s'); // Obtén la fecha y hora actual

            // ACTUALIZAR LOS DATOS DE LA ACTIVIDAD
            $query = 'UPDATE actividads SET fecha = :fecha, horainicio = :horaInicio, horafin = :horaFin, montototal = :montoTotal, nombre = :nombre, updated_at = :updated_at WHERE id = :id';
            $req_actividad = $db->prepare($query);

            $req_actividad->bindParam(':fecha', $fecha);
            $req_actividad->bindParam(':horaInicio', $horaInicio);
            $req_actividad->bindParam(':horaFin', $horaFin);
            $req_actividad->bindParam(':montoTotal', $montoTotal);
            $req_actividad->bindParam(':nombre', $nombre);
            $req_actividad->bindParam(':updated_at', $updated_at);
            $req_actividad->bindParam(':id', $id);
            $req_actividad->execute();

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }


    public static function create($fecha, $horaInicio, $horaFin, $montoTotal, $nombre)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            $query = 'INSERT INTO actividads (fecha, horainicio, horafin, montototal, nombre) VALUES (:fecha, :horaInicio, :horaFin, :montoTotal, :nombre);';
            $req_actividad = $db->prepare($query);

            $req_actividad->bindParam(':fecha', $fecha);
            $req_actividad->bindParam(':horaInicio', $horaInicio);
            $req_actividad->bindParam(':horaFin', $horaFin);
            $req_actividad->bindParam(':montoTotal', $montoTotal);
            $req_actividad->bindParam(':nombre', $nombre);
            $req_actividad->execute();

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
