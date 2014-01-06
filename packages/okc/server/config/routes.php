<?php

// resource to use for homepage
$_routes['']['class'] = 'okc\server\resources\homepage';
// resource to display for 403 http response code
$_routes['__http403']['class'] = 'okc\server\resources\http403';
// resource to display for 404 http response code
$_routes['__http404']['class'] = 'okc\server\resources\http404';

