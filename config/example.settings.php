<?php
/**
 * @file
 * Define app settings
 * rename to settings.php to use
 */

$settings['mysql'] = [
  'server' => '127.0.0.1',
  'user' => 'root',
  'password' => '', 
  'database' => 'yourdatabase',
];

// add local configuration if any. It may overrides any of the above settings
if (is_readable('settings.local.php')) {
  include('settings.local.php');
}

