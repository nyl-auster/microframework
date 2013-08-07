<?php
/**
 * Render a templates. Support wrapper templates.
 */

class view {

  public $variables = array();
  public $file = '';
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

  public function setWrapperView($file, $variables = array()) {
     $this->wrapperView = new view($file, $variables);
  }

  protected function __toString() {
    return $this->render();
  }

}

