<?php
function call($controller, $action)
{
  require_once('controllers/' . $controller . '_controller.php');

  switch ($controller) {
    case 'pages':
      $controller = new PagesController();
      break;
    case 'personas':
      // we need the model to query the database later in the controller
      require_once('models/persona.php');
      $controller = new PersonasController();
      break;
    case 'miembros':
      // we need the model to query the database later in the controller
      require_once('models/visitante.php');
      require_once('models/miembro.php');
      require_once('models/parentezco.php');
      $controller = new MiembrosController();
      break;
    case 'visitantes':
      // we need the model to query the database later in the controller
      require_once('models/visitante.php');
      $controller = new VisitantesController();
      break;
    case 'ministerios':
      // we need the model to query the database later in the controller
      require_once('models/miembro.php');
      require_once('models/historialministerio.php');
      require_once('models/ministerio.php');
      $controller = new MinisteriosController();
      break;
    case 'actividads':
      // we need the model to query the database later in the controller
      require_once('models/miembro.php');
      require_once('models/actividad.php');
      require_once('models/asistencia.php');
      $controller = new ActividadController();
      break;
  }

  $controller->{$action}();
}

// we're adding an entry for the new controller and its actions
$controllers = array(
  'pages' => ['home', 'error'],
  'personas' => ['index', 'show'],
  'miembros' => ['index', 'index_suspended', 'create', 'store', 'edit', 'update', 'show', 'delete', 'enable', 'deleteSoftMiembro', 'deleteParentezco', 'parentezco', 'storeParentezco'],
  'visitantes' => ['index', 'create', 'store', 'edit', 'update', 'show'],
  'ministerios' => ['index', 'create', 'store', 'edit', 'update', 'show', 'historialEncargadosMinisterio', 'storeEncargado', 'finalizarCargoMinisterio'],
  'actividads' => ['index', 'create', 'store', 'edit', 'update', 'show', 'asistencia']
);

if (array_key_exists($controller, $controllers)) {
  if (in_array($action, $controllers[$controller])) {
    call($controller, $action);
  } else {
    call('pages', 'error');
  }
} else {
  call('pages', 'error');
}
