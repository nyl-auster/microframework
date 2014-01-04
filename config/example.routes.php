<?php
/**
 * @file
 * resource routes example. Rename to routes.php to use.
 */

// you may override default homepage, 403 and 404 by using custom resources here.
$routes['']['class'] = 'okc\framework\resources\homepage';
$routes['__http403']['class'] = 'okc\framework\resources\http403';
$routes['__http404']['class'] = 'okc\framework\resources\http404';

# include 'okc/example/config/routes.php';

