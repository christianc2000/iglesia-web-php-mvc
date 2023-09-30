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
      require_once('models/miembro.php');
      $controller = new MiembrosController();
      break;
    case 'visitantes':
      // we need the model to query the database later in the controller
      require_once('models/visitante.php');
      $controller = new VisitantesController();
      break;
  }

  $controller->{$action}();
}

// we're adding an entry for the new controller and its actions
$controllers = array(
  'pages' => ['home', 'error'],
  'personas' => ['index', 'show'],
  'miembros' => ['index', 'show', 'create', 'store'],
  'visitantes' => ['index', 'show', 'create', 'store']
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
