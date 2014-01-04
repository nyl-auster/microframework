<?php
class resource {

  /**
   * if FALSE, resource will not be visible. 
   */
  function access() {
    return TRUE;
  }

  /**
   * response to a post request.
   * Return the get page by default.
   */
  function post() {
    return $this->get();
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

    // call post method in case of http post request
    if (isset($_POST)) {
      return $this->post();
    }

    // else call get method.
    return $this->get();
    
  }

}
