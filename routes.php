<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'home':
        $controller = new HomeController();
      break;
    }

    $controller->{ $action }();
  }

  // entries for the new controller and its actions
  $controllers = array('home' => ['index', 'error', 'submit']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('home', 'error');
    }
  } else {
    call('home', 'error');
  }
?>