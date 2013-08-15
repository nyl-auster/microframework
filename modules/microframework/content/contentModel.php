<?php
namespace microframework\content;

class contentModel {

  function insert($values) {
    $values = array_map('mysql_real_escape_string', $values);
    $query = sprintf("INSERT INTO content (title, body) VALUES ('%s', '%s')", $values['title'], $values['body']);
    mysql_query($query) or die(mysql_error());
  }

  function load($id) {
    $query = sprintf("SELECT * FROM content WHERE id = %d", $id);
    mysql_query($query) or die(mysql_error());
  }

  function update() {

  }

  function save($id = '') {
    if ($id) {
     $this->insert();
    }
    else {
      $this->save($id);
    }
  }

}

