<?php
require_once('persona.php'); // Reemplaza 'ruta_a_persona.php' con la ruta correcta al archivo de la clase Persona

class Asistencia
{
    public $actividad_id;
    public $persona_id;
    public $horallegada;
    public $created_at;
    public $updated_at;
    public function __construct($actividad_id, $persona_id, $horallegada, $created_at, $updated_at)
    {
        $this->actividad_id = $actividad_id;
        $this->persona_id = $persona_id;
        $this->horallegada = $horallegada;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM asistencias ORDER BY updated_at DESC;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $asistencia) {
            $list[] = new Asistencia($asistencia['id'], $asistencia['actividad_id'], $asistencia['persona_id'], $asistencia['horallegada'], $asistencia['created_at'], $asistencia['updated_at']);
        }
        return $list;
    }
    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM asistencias WHERE id = :id');

        $req->execute(array('id' => $id));
        $asistencia = $req->fetch();
        new Asistencia($asistencia['id'], $asistencia['actividad_id'], $asistencia['persona_id'], $asistencia['horallegada'], $asistencia['created_at'], $asistencia['updated_at']);

        return $asistencia;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }
    public static function getAllAsistencia($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM asistencias WHERE actividad_id = :id');
        $req->execute(array('id' => $id));

        foreach ($req->fetchAll() as $asistencia) {
            $list[] = new Asistencia($asistencia['id'], $asistencia['actividad_id'], $asistencia['persona_id'], $asistencia['horallegada'], $asistencia['created_at'], $asistencia['updated_at']);
        }
        return $list;
    }
}
