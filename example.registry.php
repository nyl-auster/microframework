<?php
/**
 * @file
 * resource registry example. Rename to registry.php to use.
 */
  
// register a new resource, responding to "example" url.
$registry['example'] = array(
  'class' => 'myBundle\myModule\exampleresource',
  'route' => 'example',
);

// override the default resources provided by server classe :
// Custom homepage :
$registry['homepage']['class'] = 'myBundle\myModule\myresource';
// Custom 404 resource
$registry['http404']['class'] = 'myBundle\myModule\myresource';
// Custom 403 resource.
$registry['http403']['class'] = 'myBundle\myModule\myresource';

// includes may be used to let each module have its own registry file.
include 'microframework/mybundle/mymodule/registry.php';

