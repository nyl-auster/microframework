<?php
/**
 * @file
 * Define application settings
 * rename to settings.php to use
 */

# $_settings['key'] = 'value';
# include 'okc/example/config/settings.php';

// add local configuration if any. It may overrides any of the above settings
if (is_readable('settings.local.php')) {
  include('settings.local.php');
}

