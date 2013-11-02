<?php

$listeners['app.bootstrap']['db.connect'] = array(
  'callable' => 'microframework\database\database::connect',
  'enable' => TRUE,
);
$listeners['app.close']['db.close'] = array(
  'callable' => 'microframework\database\database::close',
  'enable' => TRUE,
);

