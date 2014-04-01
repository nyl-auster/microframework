<?php
namespace okc\template;

/**
 * Generic template class. Render a template file with variables.
 *
 * @code
 * print new template('path/to/my/template.php', array('myvars' => 'myvalue'));
 * @endcode
 *
 * A view my be rendered inside another view :
 * @code
 * $view new template('path/to/my/template.php', array('myvars' => 'myvalue'));
 * $view->setParentView('path/to/parentTemplate.php');
 * print $view;
 * @endcode
 */
class template {

  protected $variables = array();
  protected $file = '';
  protected $parentTemplate = null;
  protected $childTemplateVariable = null;

  /**
   * @param string $file
   *   Relative path to the template file.
   * @param array $variables
   *   associatives array of variables to pass to the template file.
   * @param string $childTemplateVariable
   *   Wrapper template will render child view printing this variable name.
   */
  public function __construct($file, $variables = [], $childTemplateVariable = 'childTemplate') {
    $this->setFile($file);
    $this->setVariables($variables);
    $this->childTemplateVariable = $childTemplateVariable;
  }

  function setFile($file) {
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
    if ($this->parentTemplate) {
      $this->parentTemplate->variables[$this->childTemplateVariable] = $output;
      $output = $this->parentTemplate->render();
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
   * call this method allow to wrap view inside a wrapper template
   * @param string $file
   *   template file to use to wrap this view
   * @param string $variableName
   *   Name of the variable that will be used in the wrapping template to include
   *   child template.
   * @param array $variables
   *   Allow to overrides parent view variables if needed.
   */
  public function setParent($file, $variables = array(), $language = NULL) {
    if ($file) {
      return $this->parentTemplate = new template($file, $variables, $language);
    }
  }

  public function __toString() {
    return $this->render();
  }

}

