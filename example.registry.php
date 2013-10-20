<?php
/**
 * @file
 * Ressource registry example. Rename to registry.php to use.
 */
  
// register a new ressource, responding to "example" url.
$registry['example'] = array(
  'class' => 'myBundle\myModule\exampleRessource',
  'route' => 'example',
);

// override the default ressources provided by server classe :
// custom homepage
$registry['homepage']['class'] = 'myBundle\myModule\myRessource';
// custom 404 ressource
$registry['http404']['class'] = 'myBundle\myModule\myRessource';
// custom 403 ressource.
$registry['http403']['class'] = 'myBundle\myModule\myRessource';

// includes may be used to let each module have its own registry file.
include 'microframework/mybundle/mymodule/registry.php';

// this is required
return $registry;
