<?php
namespace okc\framework;

use okc\eventsManager\eventsManager;

/**
 * Generic template engine class, Usable outside of okc framework.
 */
class view {

  public $variables = array();
  public $file = '';
  private $parentView = null;
  // in which parent variable will be inject the view if wrapped.
  private $parentViewVariableName = null;

  /**
   * @param string $file
   *   full relative path to the template file.
   * @param array $variables
   *   associatives array of variables to pass to the template file.
   */
  public function __construct($file, $variables = array()) {
    eventsManager::fire('view__construct', array('file' => &$file, 'variables' => &$variables));
    $this->file = $file;
    $this->variables = $variables;
  }

  function setVariable($name, $value) {
    $this->variables[$name] = $value;
  }

  /**
   * Display a template, inside a wrapper template if asked.
   * A variable $childView is created and must be put inside wrapper template
   * to display the innerTemplate.
   * @return string
   *   content of the file, once php variables have been parsed
   */
  public function render() {
    $output = $this->includeParse($this->file, $this->variables); 
    if ($this->parentView) {
      $this->parentView->variables[$this->parentViewVariableName] = $output;
      $output = $this->parentView->render();     
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
   * @param string $file
   *   template file to use to wrap this view
   * @param string $variableName
   *   Name of the variable that will be used in the wrapping template to include
   *   child template.
   * @param array $variables
   *   Allow to overrides parent view variables if needed.
   */
  public function setParentView($file, $variables = array(), $language = NULL, $parentViewVariableName = 'childView') {
    $this->parentView = new view($file, $variables, $language);
    $this->parentViewVariableName = $parentViewVariableName;
  }

  public function __toString() {
    return $this->render();
  }

}

