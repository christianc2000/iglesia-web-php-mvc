<?php
class MiembrosController
{
    public function index()
    {
        // we store all the persona in a variable
        $miembros = Miembro::all();
        require_once('views/miembros/index.php');
    }

    public function show()
    {
        // we expect a url of form ?controller=posts&action=show&id=x
        // without an id we just redirect to the error page as we need the post id to find it in the database
        if (!isset($_GET['id']))
            return call('pages', 'error');

        // we use the given id to get the right post
        $miembro = Miembro::find($_GET['id']);
        require_once('views/miembros/show.php');
    }

    public function create()
    {
        require_once('views/miembros/create.php');
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
            $miembro = Miembro::create($ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento);

            if ($miembro) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=miembros&action=index");
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
