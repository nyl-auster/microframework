<?php
/**
 * @file
 *
 * Base class for resources.
 *
 * All content displayed by this framework is a resource object.
 * A resource may be accessible by an url if it's registered in "registry.php" file.
 * In a template, they may be called simply bi instancied them and call "render()" method,
 * which take care of access.
 */
namespace microframework\core;

abstract class resource {

  /**
   * if FALSE, resource will not be visible. 
   */
  function access() {
    return TRUE;
  }

  /**
   * Content of the resource.
   */
  abstract function content();

  /**
   * Render the content of the resource, checking access to this resource.
   */
  function render() {
    return $this->access() == TRUE ? $this->content() : '';
  }

  function __toString() {
    return $this->render();
  }

}

