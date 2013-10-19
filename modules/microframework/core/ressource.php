<?php
/**
 * @file
 *
 * Base class for ressources.
 *
 * All content displayed by this framework is a ressource.
 * A ressource may be accessible by an url if it's registered in "registry.php" file.
 * Otherwise, ressource may be rendered instanciating the class (in templates for example),
 * calling the render() method (that take cares of cheking access to the ressource).
 */

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

