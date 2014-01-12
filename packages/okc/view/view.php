<?php
namespace okc\view;

use okc\events\events;

/**
 * Generic template class. Render a template file with variables.
 *
 * @code
 * print new view('path/to/my/view.php', array('myvars' => 'myvalue'));
 * @endcode
 *
 * A view my be rendered inside another view :
 * @code
 * $view new view('path/to/my/view.php', array('myvars' => 'myvalue'));
 * $view->setParentView('path/to/parentView.php');
 * print $view;
 * @endcode
 */
class view {

  protected $variables = array();
  protected $file = '';
  protected $parentView = null;
  protected $childViewVariable = null;

  /**
   * @param string $file
   *   full relative path to the template file.
   * @param array $variables
   *   associatives array of variables to pass to the template file.
   * @param string $childView
   *   Wrapper template will render child view printing this variable name.
   */
  public function __construct($file, $variables = array(), $childViewVariable = 'childView') {
    $this->setFile($file);
    $this->setVariables($variables);
    $this->childViewVariable = $childViewVariable;
  }

  function setFile($file) {
    events::fire('viewSetFile', array('file' => &$file));
    return $this->file = $file;
  }

  function setVariable($name, $value) {
    return $this->variables[$name] = $value;
  }

  function setVariables($variables) {
    return $this->variables = $variables;
  }

  function getFile($file) {
    return $this->file = $file;
  }

  function getVariable($name) {
    return $this->variables[$name];
  }

  function getVariables() {
    return $this->variables;
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
      $this->parentView->variables[$this->childViewVariable] = $output;
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

  public function setParent($file, $variables = array(), $language = NULL) {
    $this->setParentView($file, $variables = array(), $language = NULL);
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
  public function setParentView($file, $variables = array(), $language = NULL) {
    if ($file) {
      $this->parentView = new view($file, $variables, $language);
    }
  }

  public function __toString() {
    return $this->render();
  }

}

