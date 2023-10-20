<?php
require_once('models/visitante.php');
require_once('models/miembro.php');
require_once('models/parentezco.php');
class MiembrosController
{
    public function index()
    {
        $miembros = Miembro::allPerson();

        require_once('views/miembros/index.php');
    }

    public function show()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $miembro = Miembro::find($_GET['id']);
        $visitante = Visitante::find($_GET['id']);

        require_once('views/miembros/show.php');
    }
    public function parentezco()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $miembros = Miembro::allPerson();
        $parentezcos = Parentezco::getMiembroParentezco($_GET['id']);
        $parentezcos_relacionados = Parentezco::getMiembroParentezcoRelacionados($_GET['id']);
        $miembro = Miembro::find($_GET['id']);
        require_once('views/miembros/parentezco.php');
    }
    public function storeParentezco()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $miembroa_id = $_POST['miembroa_id'];
            $miembrob_id = $_POST['miembrob_id'];
            $parentezco = $_POST['parentezco'];
            echo "ingresa a storeParentezco " . $miembroa_id . ", " . $miembrob_id . ", " . $parentezco;
            $parentezco = Parentezco::create($parentezco, $miembroa_id, $miembrob_id);
            //    echo "pasa a storeParentezco " . $parentezco;
            if ($parentezco) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=miembros&action=parentezco&id=" . $miembroa_id);
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function deleteParentezco()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $miembroa_id = $_POST['miembroa_id'];
            $parentezco_id = $_POST['parentezco_id'];

            echo "antes del delete" . $parentezco_id;

            $parentezco = Parentezco::delete($parentezco_id);
            echo "pasa a storeParentezco " . $parentezco;
            if ($parentezco) {
                echo "id: " . $miembroa_id;
                echo "id: " . $parentezco_id;
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=miembros&action=parentezco&id=" . $miembroa_id);
                exit();
            } else {
                echo "no entra";
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
        $miembro = Miembro::find($_GET['id']);
        require_once('views/miembros/edit.php');
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
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            // echo $correo;
            $miembro = Miembro::update($id, $ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento);

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

    public function deleteSoftMiembro()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $miembro = Miembro::deleteSoft($_GET['id']);

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
    public function index_suspended()
    {
        $miembros = Miembro::allPersonSuspended();
        require_once('views/miembros/index-suspended.php');
    }
    public function enable()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        echo "entra enable";
        $miembro = Miembro::enable($_GET['id']);

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
    public function delete()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $miembro = Miembro::delete($_GET['id']);

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
