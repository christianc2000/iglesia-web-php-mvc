<?php
require_once('persona.php'); // Reemplaza 'ruta_a_persona.php' con la ruta correcta al archivo de la clase Persona

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
    public static function allPerson()
    {
        $list = [];
        $db = Db::getInstance();

        $req = $db->query("SELECT personas.*, visitantes.fecha_registro_visitante FROM visitantes, personas WHERE visitantes.id = personas.id AND personas.tipo='V' ORDER BY personas.updated_at DESC");

        // Recorremos los resultados de la consulta
        foreach ($req->fetchAll() as $row) {
          
            $personas = new Persona($row['id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['estado'], $row['tipo'], $row['sexo'], $row['fecha_nacimiento'], $row['created_at'], $row['updated_at']);
            $visitantes = new Visitante($row['id'], $row['fecha_registro_visitante'], $row['created_at'], $row['updated_at']);
            $list[] = [$visitantes, $personas];
        }

        return $list;
    }
    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT personas.*,visitantes.fecha_registro_visitante FROM visitantes, personas WHERE personas.id = :id AND personas.id=visitantes.id');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        $row = $req->fetch();
        $persona = new Persona($row['id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['estado'], $row['tipo'], $row['sexo'], $row['fecha_nacimiento'], $row['created_at'], $row['updated_at']);
        $visitante = new Visitante($row['id'], $row['fecha_registro_visitante'], $row['created_at'], $row['updated_at']);
      //  $list[] = $persona;

        return [$visitante, $persona];
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
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
            $db->commit();
            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }

    public static function update($id, $ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento, $tipo)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // ACTUALIZAR LOS DATOS DE LA PERSONA
            $updated_at='NOW()';
            $query = 'UPDATE personas SET ci = :ci, nombre = :nombre, apellido = :apellido, celular = :celular, direccion = :direccion, correo = :correo, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento, tipo=:tipo, updated_at=:updated_at WHERE id = :id';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':ci', $ci);
            $req_persona->bindParam(':nombre', $nombre);
            $req_persona->bindParam(':apellido', $apellido);
            $req_persona->bindParam(':celular', $celular);
            $req_persona->bindParam(':direccion', $direccion);
            $req_persona->bindParam(':correo', $correo);
            $req_persona->bindParam(':sexo', $sexo);
            $req_persona->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $req_persona->bindParam(':tipo', $tipo);
            $req_persona->bindParam(':updated_at',$updated_at);
            $req_persona->bindParam(':id', $id);
            $req_persona->execute();

            // ACTUALIZAR LOS DATOS DEL MIEMBRO (si es necesario)
            // Si tienes campos específicos en la tabla de miembros que deseas actualizar, sigue un proceso similar al de personas.
            if($tipo=="M"){
                $fecha_registro_miembro = 'NOW()'; // Utilizamos la fecha y hora actual
                $query = 'INSERT INTO miembros (id, fecha_registro_miembro) VALUES (:id, :fecha_registro_miembro)';
                $req_miembro = $db->prepare($query);
                $req_miembro->bindParam(':id', $id);
                $req_miembro->bindParam(':fecha_registro_miembro', $fecha_registro_miembro);
                $req_miembro->execute();
            }
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
