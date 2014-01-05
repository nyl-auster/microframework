<?php
/**
 * @file
 * Define application settings
 * rename to settings.php to use
 */

// translations settings. used by okc\framework\server
$_settings['translator'] = array(
  'enabled' => TRUE,
  'defaultLanguage' => 'en',
);

# include 'okc/example/config/settings.php';

// add local configuration if any. It may overrides any of the above settings
if (is_readable('settings.local.php')) {
  include('settings.local.php');
}

