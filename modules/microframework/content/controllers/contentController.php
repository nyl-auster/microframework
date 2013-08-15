<?php
namespace microframework\content\controllers;

# framework packages
use microframework\core\controller;
use microframework\core\view;

# module packages
use microframework\content\models\contentModel;

class contentController extends controller {

  /**
   * Display a content form
   */
  public function form($errors = array()) {
    return new view('modules/microframework/content/views/form.html.php');
  }

  /**
   * Callback form submission
   */
  public function formSave() {
    $content = new contentModel();
    $this->formValidate();
    if (!empty($_POST['_errors'])) {
      return $this->form();
    }
    else {
      return 'Le formulaire a été correctement soumis';
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

