<?php
/**
 * DefaultController
 *
 * Extends your custom controller from this one.
 */

class defaultController {

  protected $app = '';

  function __construct($app) {
    $this->app = $app;
  }

  function view($template, $variables = array()) {
    return $this->app->view($template, $variables);
  }

  /**
   * Default page not found callback
   */
  public function pageNotFound() {
    header("HTTP/1.1 404 Not Found");
    return 'page Not found';
  }

  function index() {
    return 'This is the default Homepage. Update or create your /conf/routes.ini to route homepage to a custom controller.';
  }

}

