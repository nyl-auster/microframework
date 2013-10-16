<?php

$settings['mysql'] = [
  'server' => '127.0.0.1',
  'user' => 'root',
  'password' => '', 
  'database' => 'yourdatabase',
];

// include dev settings and local settings if any
if (is_readable('settings-dev.php')) {
  include('settings-dev.php');
}

if (is_readable('settings-local.php')) {
  include('settings-local.php');
}

