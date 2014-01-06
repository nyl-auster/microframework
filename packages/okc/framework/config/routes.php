<?php

// resource to use for homepage
$_routes['']['class'] = 'okc\framework\resources\homepage';
// resource to display for 403 http response code
$_routes['__http403']['class'] = 'okc\framework\resources\http403';
// resource to display for 404 http response code
$_routes['__http404']['class'] = 'okc\framework\resources\http404';

$_routes['admin/routes'] = array('class' => 'okc\framework\resources\adminRoutes');
$_routes['admin/translations'] = array('class' => 'okc\framework\resources\adminTranslations');
$_routes['admin/settings'] = array('class' => 'okc\framework\resources\adminSettings');

