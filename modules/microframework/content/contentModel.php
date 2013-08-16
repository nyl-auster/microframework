<?php
namespace microframework\content;

use microframework\core\mysqlModel;

class contentModel extends mysqlModel {

  private $table = 'content';

  function insert($values) {
    $sql = "INSERT INTO $this->table (title, body, state) VALUES (@title:%s, @body:%s, @state:%d)";
    $this->execute($sql, $values);
  }

  function update($values) {
    $sql = "UPDATE $this->table SET title=@title:%s, body=@body:%s, state=@state:%d WHERE id=@id:d";
    $this->execute($sql, $values);
  }

  function delete($id) {
    $sql = "DELETE from $this->table WHERE id = @id:%d";
    $this->execute($sql, array('id' => $id));
  }

  function save($values) {
    if (!empty($values['id'])) {
      $this->update($values);
    }
    else {
      $this->insert($values);
    }
  }

  function load($id) {
    $sql = "SELECT * FROM $this->table WHERE id = @id:%d";
    $result = $this->execute($query, array('id' => $id));
    $content = null;
    while($row = mysql_fetch_assoc($result)) {
      $content = $row; 
    }
    return $content;
  }

  function listing($conditions = array()) {
    $sql = "SELECT * FROM $this->table";
    $result = $this->execute($sql);
    return $this->result($result);
  }

}

