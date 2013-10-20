<?php
namespace microframework\core\resources;

use microframework\core\resource;

class homepage extends resource {

  function get() {
     return "This is the default homepage.";
  }

}

