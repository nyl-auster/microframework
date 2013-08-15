<?php
namespace microframework\content;

class contentModel {

  private $table = 'content';

  function insert($values) {
    $values = array_map('mysql_real_escape_string', $values);
    $query = sprintf("INSERT INTO $this->table (title, body) VALUES ('%s', '%s')", $values['title'], $values['body']);
    mysql_query($query) or die(mysql_error());
  }

  function update($values) {
    $values = array_map('mysql_real_escape_string', $values);
    $query = sprintf("UPDATE $this->table SET title='%s', body='%s' WHERE id=%d", $values['title'], $values['body'], $values['id']);
    mysql_query($query) or die(mysql_error());
  }

  function delete($id) {
    $query = sprintf("DELETE from $this->table WHERE id = %d",$id);
    mysql_query($query) or die(mysql_error());
  }

  function save($values) {
    if (!empty($values['id'])) {
      $this->update($values);
    }
    else {
      $this->insert($id);
    }
  }

  function load($id) {
    $query = sprintf("SELECT * FROM content WHERE id = %d", $id);
    $result = mysql_query($query) or die(mysql_error());
    $content = null;
    while($row = mysql_fetch_assoc($result)) {
      $content = $row; 
    }
    return $content;
  }

}

