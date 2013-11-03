<?php
/**
 * @file
 * Define a list of listeners for app events
 * Rename to listeners.php file to use
 */

include "modules/microframework/database/config/listeners.php";

// example listener
// $listener[event name][callable name]
$listeners['app.bootstrap']['mymodule.hello'] = [ 
  'callable' => 'vendorName\moduleName\className::methodName',
  'enable' => TRUE, // set to false to disabled this event subscriber
];

