<?php
namespace microframework\database;

class database {

  function connect() {
    if (isset($settings['mysql'])) {
      $mysqlLink = mysql_connect($settings['mysql']['server'], $settings['mysql']['user'], $settings['mysql']['password'])
        or die("Impossible de se connecter : " . mysql_error());
      mysql_select_db($settings['mysql']['database']);
    }
  }

  function close() {
    if (isset($mysqlLink)) {
      mysql_close($mysqlLink);
    }
  }

}

