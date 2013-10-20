<?php
/**
 * @file
 *
 * Base class for resources.
 *
 * All content displayed by this framework is a resource object.
 *
 * A resource may be accessible by an url if it's registered in "routes.php" file.
 * Otherwise, instanciate a resource by yourself and use render() method to display it,
 * as render() takes care of access.
 *
 * The only required method to create a resource is content() from now, which must
 * return html, json or any final representation ready to display on a page.
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

}

