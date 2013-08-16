<?php
namespace microframework\content;

use microframework\core\mysqlQuery;

class contentModel {

  private $table = 'content';
  private $query = null;

  function __construct() {
    $this->query = new mysqlQuery();
  }

  function insert($values) {
    $sql = "INSERT INTO $this->table (title, body, state) VALUES (@title:%s, @body:%s, @state:%d)";
    $this->query->execute($sql, $values);
  }

  function update($values) {
    $sql = "UPDATE $this->table SET title=@title:%s, body=@body:%s, state=@state:%d WHERE id=@id:d";
    $this->query->execute($sql, $values);
  }

  function delete($id) {
    $sql = sprintf("DELETE from $this->table WHERE id = @id:%d");
    $this->query->execute($sql, array('id' => $id));
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
    $result = $this->query->execute($query, array('id' => $id));
    $content = null;
    while($row = mysql_fetch_assoc($result)) {
      $content = $row; 
    }
    return $content;
  }

  function listing($conditions = array()) {
    $sql = "SELECT * FROM $this->table";
    $result = $this->query->execute($sql);
    return $this->query->result($result);
  }

}

