<?php
namespace microframework\content;

use microframework\core\controller;
use microframework\core\view;
use microframework\content\contentModel;

class contentController extends controller {

  protected $objectModel = null;
  protected $objectUrlId = false;
  protected $viewsPath = 'modules/microframework/content/views/';

  function __construct() {
    $this->objectModel = new contentModel();
    $this->objectUrlId = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : false;
  }
  
  // display an object
  public function view() {
    $object = $this->objectModel->load($this->objectUrlId);
    if (!$object) return $this->pageNotFound();
    return new view("$this->viewsPath/view.html.php", array('object' => $object));
  }

  // display an object
  public function listing() {
    $objects = $this->objectModel->listing();
    return new view("$this->viewsPath/list.html.php", array('objects' => $objects));
  }

  // form for insert or update
  function form() {

    // are we editing an existing object or creating a new one ?
    $object = array();
    if ($this->objectUrlId) {
      $object = $this->objectModel->load($this->objectUrlId);
      if (!$object) return $this->pageNotFound();
    }

    // if form has been submitted, validate its datas
    $errors = array();
    if (isset($_POST['form_content_submit'])) {
      $errors = $this->formValidate();
      if (!$errors) {
        $this->objectModel->save($_POST);
      }
    }

    return new view("$this->viewsPath/form.html.php", array('object' => $object, 'errors' => $errors));
  }

  // Validate submitted form datas
  private function formValidate() {
    $errors = array();
    if (empty($_POST['title'])) {
      $errors['title'] = "Le champ titre est obligatoire ! ";
    }
    if (empty($_POST['body'])) {
      $errors['body'] = "Le corps de l'article est obligatoire ! ";
    }
    return $errors;
  }

}

