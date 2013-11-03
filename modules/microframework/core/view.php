<?php
namespace microframework\core;

/**
 * Generic template engine class.
 */
class view {

  public $variables = [];
  public $file = '';
  private $wrapperView = null;

  /**
   * @param string $file
   *   full relative path to the template file.
   * @param array $variables
   *   associatives array of variables to pass to the template file.
   */
  public function __construct($file, $variables = []) {
    $this->file = $file;
    $this->variables = $variables;
  }

  function setVariable($name, $value) {
    $this->variables[$name] = $value;
  }

  /**
   * Display a template, inside a wrapper template if asked.
   * A variable $innerView is created and must be put inside wrapper template
   * to display the innerTemplate.
   * @return string
   *   content of the file, once php variables have been parsed
   */
  public function render() {
    $output = $this->includeParse($this->file, $this->variables); 
    if ($this->wrapperView) {
      $this->wrapperView->variables['innerView'] = $output;
      $output = $this->wrapperView->render();     
    }
    return $output;
  }

  /**
   * Include a file and parse php variablews without printing it.
   * @return string
   */
  public function includeParse($file, $variables = array()) {
    if ($variables) extract($variables);
    ob_start();
    include($file);
    $ob_content = ob_get_contents();
    ob_end_clean();
    return $ob_content;
  }

  /**
   * call this function in a template allow to wrap him in a wrapper template
   */
  public function setWrapperView($file, $variables = array()) {
    $this->wrapperView = new view($file, $variables);
  }

  public function __toString() {
    return $this->render();
  }

}

