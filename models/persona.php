<?php

class Persona
{
    public $id;
    public $ci;
    public $nombre;
    public $apellido;
    public $celular;
    public $direccion;
    public $correo;
    public $estado;
    public $tipo;
    public $sexo;
    public $fecha_nacimiento;
    public $created_at;
    public $updated_at;
    public function __construct($id, $ci, $nombre, $apellido, $celular, $direccion, $correo, $estado, $tipo, $sexo, $fecha_nacimiento, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->ci = $ci;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->celular = $celular;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->estado = $estado;
        $this->tipo = $tipo;
        $this->sexo = $sexo;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM personas');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $persona) {
            $list[] = new Persona($persona['id'], $persona['ci'], $persona['nombre'], $persona['apellido'], $persona['celular'], $persona['direccion'], $persona['correo'], $persona['estado'], $persona['tipo'], $persona['sexo'], $persona['fecha_nacimiento'], $persona['created_at'], $persona['updated_at']);
        }

        return $list;
    }
    public static function find($id)
    {
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM personas WHERE id = :id');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        $persona = $req->fetch();

        return new Persona($persona['id'], $persona['ci'], $persona['nombre'], $persona['apellido'], $persona['celular'], $persona['direccion'], $persona['correo'], $persona['estado'], $persona['tipo'], $persona['sexo'], $persona['fecha_nacimiento'], $persona['created_at'], $persona['updated_at']);
    }
}
