<?php

class http404Test extends microframework_TestCase {

  public function testHttp404() {
    $resource = $this->server->getResource('777aaaaaaaaaaaaaaaaaaaa777');
    $this->assertInstanceOf('\microframework\core\resource', $resource);
  }

}

