<?php
function call($controller, $action)
{
  require_once('controllers/' . $controller . '_controller.php');

  switch ($controller) {
    case 'pages':
      $controller = new PagesController();
      break;
    case 'personas':
      require_once('models/persona.php');
      $controller = new PersonasController();
      break;
    case 'miembros':
      $controller = new MiembrosController();
      break;
    case 'visitantes':
      $controller = new VisitantesController();
      break;
    case 'ministerios':
      $controller = new MinisteriosController();
      break;
    case 'actividads':
      $controller = new ActividadController();
      break;
  }

  $controller->{$action}();
}

// Entradas para el controlador y sus actions
$controllers = array(
  'pages' => ['home', 'error'],
  'personas' => ['index', 'show'],
  'miembros' => ['index', 'index_suspended', 'create', 'store', 'edit', 'update', 'show', 'delete', 'enable', 'deleteSoftMiembro', 'deleteParentezco', 'parentezco', 'storeParentezco'],
  'visitantes' => ['index', 'create', 'store', 'edit', 'update', 'show'],
  'ministerios' => ['index', 'create', 'store', 'edit', 'update', 'show', 'historialEncargadosMinisterio', 'storeEncargado', 'finalizarCargoMinisterio'],
  'actividads' => ['index', 'create', 'store', 'edit', 'update', 'show', 'asistencia', 'storeAsistencia']
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
