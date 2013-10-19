<?php
namespace microframework\core;

abstract class ressource {

  function access() {
    return TRUE;
  }

  /**
   * Render the content of the ressource
   */
  abstract function render();

}

