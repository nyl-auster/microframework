<?php
/**
 * @file
 * resource routes example. Rename to routes.php to use.
 */

// you may override default homepage, 403 and 404 by using custom resources here.
$routes['']['class'] = 'okc\framework\resources\homepage';
$routes['__http403']['class'] = 'okc\framework\resources\http403';
$routes['__http404']['class'] = 'okc\framework\resources\http404';

// Example route : register a new resource, responding to "hello-world" url.
// class is the namespace of the class to use. Uncomment to test.
# $routes['hello-world'] = array('class' => 'okc\example\helloWorld');

// includes may be used to let each module have its own routes file.
# include 'yourName/yourBundle/config/routes.php';

