<?php
namespace microframework\core;

use microframework\core\ressourceInterface;

abstract class ressource {

  /**
   * if FALSE, ressource will not be visible.
   */
  function access() {
    return TRUE;
  }

  /**
   * Content of the ressource.
   */
  abstract function content();

  /**
   * Render the content of the ressource, checking access to this ressource.
   */
  function render() {
    if ($this->access() == TRUE) {
      return $this->content();
    }
    else {
      return '';
    }
  }

  function __toString() {
    return $this->render();
  }

}

