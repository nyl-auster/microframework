<?php
/**
 * @file
 *
 * Base class for ressources.
 *
 * All content displayed by this framework is a ressource object.
 * A ressource may be accessible by an url if it's registered in "registry.php" file.
 * In a template, they may be called simply bi instancied them and call "render()" method,
 * which take care of access.
 */
namespace microframework\core;

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
    return $this->access() == TRUE ? $this->content() : '';
  }

  function __toString() {
    return $this->render();
  }

}

