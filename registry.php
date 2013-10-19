<?php
/**
 * Routes and routes files. Example route :
 * Rename to routes.php to use
 *
 * $routes['hello-world'] = [
 *  'class' => 'microframework\example\controllers\exampleController',
 *  'method' => 'helloWorld',
 *];
 */

$registry['exampleRessource'] = array(
  'class' => 'microframework\core\ressources\exampleRessource',
  'route' => 'example',
);

