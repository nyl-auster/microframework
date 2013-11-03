<?php

class serverTest extends microframework_TestCase {

  public function testGetResource() {
    $resource = $this->server->getResource('');
    $this->assertInstanceOf('\microframework\core\resource', $resource);
  }

}

