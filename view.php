<?php
/**
 * Render a templates. Support wrapper templates.
 */

class view {

  public $variables = array();
  public $file = '';
  public $blocks = '';
  private $wrapperView = null;

  public function __construct($file, $variables = array()) {
    $this->file = $file;
    $this->variables = $variables;
  }

  /**
   * Display a template, inside a wrapper template if asked.
   * A variable $innerView is created and must be put inside wrapper template
   * to display the innerTemplate.
   */
  public function render() {
    $output = $this->includeParse($this->file, $this->variables); 
    if ($this->wrapperView) {
      // let inner template override variables from wrapper template. Usefull to add some code to parent
      // from a child template (add css files, add js files, change page title etc...)
      $this->wrapperView->variables = array_merge($this->wrapperView->variables, $this->variables);
      $this->wrapperView->variables['innerView'] = $output;
      $output = $this->wrapperView->render();     
    }
    return $output;
  }

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

  protected function __toString() {
    return $this->render();
  }

}

