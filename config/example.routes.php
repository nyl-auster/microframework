<?php
/**
 * @file
 * resource routes example. Rename to routes.php to use.
 */

// register a new resource, responding to "example" url.
// class is the namespace of the class to load.
$routes['example'] = ['class' => 'myBundle\myModule\exampleresource'];

// override the default resources provided by server classe :
// Custom homepage :
$routes['']['class'] = 'myBundle\myModule\myresource';
// Custom 404 resource
$routes['__http404']['class'] = 'myBundle\myModule\myresource';
// Custom 403 resource.
$routes['__http403']['class'] = 'myBundle\myModule\myresource';

// includes may be used to let each module have its own routes file.
include 'microframework/mybundle/mymodule/routes.php';

