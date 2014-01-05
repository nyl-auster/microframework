<?php
namespace okc\framework\resources;

use okc\framework\resource;
use okc\framework\view;
use okc\framework\translator;
use okc\framework\server;

class homepage extends resource {

  function get() {
     $language = server::getCurrentLanguage();
     return new view('packages/okc/framework/views/homepage.php', array(), $language);
  }

}

