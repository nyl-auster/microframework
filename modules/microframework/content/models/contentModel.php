<?php
namespace microframework\content\models;

class contentModel {

  function insert() {
    print 'coucou';
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

