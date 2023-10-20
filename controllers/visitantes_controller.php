<?php
require_once('models/visitante.php');
class VisitantesController
{
    public function index()
    {
        $visitantes = Visitante::allPerson();
        require_once('views/visitantes/index.php');
    }

    public function show()
    {
        // we expect a url of form ?controller=posts&action=show&id=x
        // without an id we just redirect to the error page as we need the post id to find it in the database
        if (!isset($_GET['id']))
            return call('pages', 'error');

        // we use the given id to get the right post
        $visitante = Visitante::find($_GET['id']);
        require_once('views/visitantes/show.php');
    }
    public function create()
    {
        require_once('views/visitantes/create.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ci = $_POST['ci'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $celular = $_POST['celular'];
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            // echo $correo;
            $visitante = Visitante::create($ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento);

            if ($visitante) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=visitantes&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }

    public function edit()
    {

        if (!isset($_GET['id']))
            return call('pages', 'error');
        $visitante = Visitante::find($_GET['id']);

        require_once('views/visitantes/edit.php');
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $ci = $_POST['ci'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $celular = $_POST['celular'];
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $tipo = $_POST['tipo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            // echo $correo;
            $visitante = Visitante::update($id, $ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento, $tipo);

            if ($visitante) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=visitantes&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
}
