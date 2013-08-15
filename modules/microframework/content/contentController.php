<?php
namespace microframework\content;

// framework classes
use microframework\core\controller;
use microframework\core\view;

// module classes
use microframework\content\contentModel;

class contentController extends controller {

  protected $objectModel = null;

  function __construct() {
    $this->objectModel = new contentModel();
  }

  /**
   * Display a object form
   */
  public function form() {
    $object = $this->objectModel->load($this->GET('id'));
    if (!$object) return $this->pageNotFound();
    return new view('modules/microframework/content/views/form.html.php', array('object' => $object));
  }

  /**
   * Display a object
   */
  public function view() {
    $object = $this->objectModel->load($this->GET('id'));
    if (!$object) return $this->pageNotFound();
    return new view('modules/microframework/content/views/view.html.php', array('object' => $object));
  }

  /**
   * Callback form submission
   */
  public function formSave() {
    $this->formValidate();
    if (!empty($_POST['_errors'])) {
      return $this->form();
    }
    else {
      $this->objectModel->save($_POST); 
      return 'Le formulaire correctement soumis';
    }
  }

  /**
   * Validate submitted form datas
   */
  private function formValidate() {
    if (empty($_POST['title'])) {
      $_POST['_errors']['title'] = "Title field is required";
    }
    if (empty($_POST['body'])) {
      $_POST['_errors']['body'] = "Body field is required";
    }
  }

}

