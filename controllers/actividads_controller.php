<?php
require_once('models/miembro.php');
require_once('models/actividad.php');
require_once('models/asistencia.php');
class ActividadController
{
    public function index()
    {
        $actividades = Actividad::all();

        require_once('views/actividades/index.php');
    }

    public function show()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        //    $visitante = Visitante::find($_GET['id']);

        require_once('views/actividades/show.php');
    }

    public function edit()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        require_once('views/actividades/edit.php');
    }

    public function create()
    {
        require_once('views/actividades/create.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = $_POST['fecha'];
            $horaInicio = $_POST['horaInicio'];
            $horaFin = $_POST['horaFin'];
            $montoTotal = $_POST['montoTotal'];
            $nombre = $_POST['nombre'];

            $created = Actividad::create($fecha, $horaInicio, $horaFin, $montoTotal, $nombre);

            if ($created) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividades&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la actividad falla
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
            $fecha = $_POST['fecha'];
            $horaInicio = $_POST['horaInicio'];
            $horaFin = $_POST['horaFin'];
            $montoTotal = $_POST['montoTotal'];
            $nombre = $_POST['nombre'];

            $updated = Actividad::update($id, $fecha, $horaInicio, $horaFin, $montoTotal, $nombre);

            if ($updated) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividades&action=index");
                exit();
            } else {
                // Maneja el caso en el que la actualización de la actividad falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }


    public function delete()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        // $miembro = Miembro::delete($_GET['id']);

        // if ($miembro) {
        //     // Redirige a una página de éxito o muestra un mensaje de éxito
        //     header("Location: ?controller=miembros&action=index");
        //     exit();
        // } else {
        //     // Maneja el caso en el que la creación de la persona falla
        //     // Puedes redirigir a una página de error o mostrar un mensaje de error
        //     header("Location: ?controller=home&action=error");
        //     exit();
        // }
    }
    public function asistencia()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $miembros = Miembro::allPerson();
        $actividad = Actividad::find($_GET['id']);

        $asistencias = Asistencia::getAllAsistencia($_GET['id']);
        //echo $asistencias[1][1];
        require_once('views/actividades/asistencia.php');
    }

    public function storeAsistencia()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $actividad_id = $_POST['actividad_id'];
            $persona_id = $_POST['persona_id'];

            // echo "ingresa a storeParentezco " . $miembroa_id . ", " . $miembrob_id . ", " . $parentezco;
            $asistencia = Asistencia::create($persona_id, $actividad_id);
            //    echo "pasa a storeParentezco " . $parentezco;
            if ($asistencia) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividads&action=asistencia&id=" . $actividad_id);
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
