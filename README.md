HOW TO USE
------------

1 - Call this code in the index.php at the root of your application.
@code
require 'app.php';
$app = new app();
print $app->executeRoute($app->getPath());
@endcode

2 - Create routes in a ini file, in "conf" directory at the root of your application.
@code
[hello/world]
path = controllers
class = myController
method = helloWorld
@encode

- hello/world mean than your controller will respond going on "domain.com/index.php/hello/world" url.
- class is your class name to instanciate. Your file have to be name myControler.php in this example.
- method : method that will be called for this url.

3 - Create your controller in "controllers/myController.php" file, extending defaultController :
@code
class myController extends defaultController {

  function helloWorld() {
    return 'Hello world';
    // you may use a template this way :
    // return $this->view('templates/helloWorld.html.php');
  }

}
@endcode

4 - goto to yourdomain.com/index.php/hello/world and see "hello world" displaying.

DIRECTORIES STRUCTURE
--------------------

app.php
conf/
libraries/
vendor/
templates/
controllers/


