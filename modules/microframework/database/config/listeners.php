<?php
/**
 * @file
 * register listeners for a mysql connexion
 */

$listeners['app.bootstrap']['db.connect'] = [
  'callable' => 'microframework\database\database::connect',
  'enable' => TRUE,
];
$listeners['app.close']['db.close'] = [
  'callable' => 'microframework\database\database::close',
  'enable' => TRUE,
];

