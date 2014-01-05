<?php
/**
 * @file
 * resource routes example. Rename to routes.php to use.
 */

// class is the class name with its full namespace. Edit them to
// use your custom resources instead of core resources for homepage,
// 403 and 404 resources.

// resource to use for homepage
$routes['']['class'] = 'okc\framework\resources\homepage';

// resource to display for 403 http response code
$routes['__http403']['class'] = 'okc\framework\resources\http403';

// resource to display for 404 http response code
$routes['__http404']['class'] = 'okc\framework\resources\http404';

// Add your custom routes here, or include them.

// example page : go to http://yoursite.local/index.php/hello-world to display it.
include 'okc/example/config/routes.php';

