<?php
/**
 * @file
 *
 * Base class for all resources.
 *
 * Most of content displayed by this framework is a resource object.
 *
 * A resource may be accessible by an url if it's registered in "routes.php" file.
 * Otherwise, instanciate a resource by yourself and use render() method to display it,
 * as render() takes care of checking access method.
 *
 * The only required method to create a resource is get() from now, which must
 * return html, json or any final representation ready to display on a page.
 */
namespace okc\resource;

abstract class resource {

  /**
   * if FALSE, resource will not be visible.
   * When resource is requested by http, returning FALSE will thow
   * a 403 access denied. 
   * It will simply returned an empty string if resource is manually called via
   * render method.
   */
  function access() {
    return TRUE;
  }

  /**
   * Response to a get request 
   */
  abstract function get();

  /**
   * Render the content of the resource, checking access to this resource.
   */
  function render() {

    // do not display anything if access is disallowed
    if ($this->access() != TRUE) {
      return '';
    }

    return $this->get();

  }

}

