<?php
namespace okc\framework\resources;

use okc\resource\resource;
use okc\view\view;

class adminTranslations extends resource {

  function get() {
    global $_translations;
    $array = array();
    foreach ($_translations as $lang => $translations) {
      foreach ($translations as $stringId => $translation) {
         $array[$stringId][$lang] = $translation;
      }
    }
    return new view('packages/okc/framework/views/adminTranslations.php', array('translations' => $array));
  }

}

