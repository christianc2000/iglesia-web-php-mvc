<?php
require_once('models/miembro.php');
require_once('models/historialministerio.php');
require_once('models/ministerio.php');
class MinisteriosController
{
    public function index()
    {
        $ministerios = Ministerio::all();

        require_once('views/ministerios/index.php');
    }
    public function create()
    {
        require_once('views/ministerios/create.php');
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];

            echo "está en el store ministerio";
            $ministerio = Ministerio::create($nombre, $descripcion, $estado);

            if ($ministerio) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=ministerios&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function show()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');

        $ministerio = Ministerio::find($_GET['id']);

        require_once('views/ministerios/show.php');
    }
    public function edit()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');

        $ministerio = Ministerio::find($_GET['id']);

        require_once('views/ministerios/edit.php');
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $descripcion = $_POST['descripcion'];
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];


            // echo $correo;
            $ministerio = Ministerio::update($id, $nombre, $descripcion, $estado);

            if ($ministerio) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=ministerios&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function historialEncargadosMinisterio()
    {

        if (!isset($_GET['id'])) //el id del ministerio
            return call('pages', 'error');
        $miembros = Miembro::allPerson(); //todos los miembros que pueda seleccionar
        $historialv_ministerio = HistorialMinisterio::getMiembrosVigentesMinisterio($_GET['id']); //retorna el historial del ministerio con miembros vigentes que pertenecen a él
        //    print_r($historialv_ministerio);
        //    var_dump($historialv_ministerio[0][1]);
        $historialc_ministerio = HistorialMinisterio::getMiembrosCaducadosMinisterio($_GET['id']); //retorna el historial del ministerio con miembros caducados que pertenecen a él
        $ministerio = Ministerio::find($_GET['id']);
        require_once('views/ministerios/historial.php');
    }
    public function storeEncargado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ministerio_id = $_POST['id'];
            $miembro_id = $_POST['miembro_id'];
            $cargo = $_POST['cargo'];

            $parentezco = HistorialMinisterio::create(true, $cargo, $miembro_id, $ministerio_id);

            if ($parentezco) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=ministerios&action=historialEncargadosMinisterio&id=" . $ministerio_id);
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function finalizarCargoMinisterio()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ministerio_id = $_POST['ministerio_id'];
            $historial_id = $_POST['historial_id'];

            echo "antes del ministerio id" . $ministerio_id;
            echo "antes del historial id" . $historial_id;
            $historialministerio = HistorialMinisterio::finalizarCargoMinisterio($historial_id);
            echo "pasa a storeParentezco " . $historialministerio;
            if ($historialministerio) {
                header("Location: ?controller=ministerios&action=historialEncargadosMinisterio&id=" . $ministerio_id);
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
}
