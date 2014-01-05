OKC framework
==============

OKC framework is a tiny View-Controller php framework.

Requirements
------------
* Php >= 5.3
* Apache
* Linux

Features
---------
* Build site around resources. A resource is a class that represents any piece of content of your application; providing methods to customize its behavior and visibility. They may be used to create blocks, pages, rss, xml, json etc...
* Router : map an url to a resource with routes.php file to create a web page. 
* Blocks : call resource directly from wihtin your templates. Use access methods to set their visibility rules.
* Parent and children template / views : a template may be wrapped by any other template and overrides parent template variables if needed.
* Events & listeners manager : subscribe to core events with php callables or fire custom events.
* PSR-0 standard : you may use any php class or libary implementing PSR-0 in your project. Just drop them in "packages" directory or create a vendors "directory" for them.
* Fully customize 404 and 403 pages with resources of your own.
* Settings file to hold configuration.

Documentation
==============

Installation
-------------

Clone the git repository. Rename config/example.routes.php file to config/routes.php to create new routes or uncomment existing ones.
By default, only homepage resource, 404 and 403 resource will be available. Follow documentation to create a new available resource.

Directory structure & autoloader PSR-0
-------------------

PSR-O autoloader is used to load classes. It looks in "packages" directory. See PSR-0 https://github.com/php-fig/fig-standards/blob/master/accepted/fr/PSR-0.md .

Framework code resides in packages/okc/framework directory.

Example module
--------------

packages/okc/example package can be used as a starter to create a new package quickly.

Manul Quickstart : Hello World
------------------------

* Rename config/example.routes.php to config/routes.php
* Create a new route for our "helloWorld" resource in config/routes.php.

```php
  $routes['hello-world'] = array('class' => 'foo\bar\helloWorld');
```

* In package directory foo/bar/resources directories. "Foo" is Vendor name and "bar" package name. "Resources" will contain resources.
* Create a new php file call helloWorld.php in a "resources" directory :

```php
    <?php
    namespace foo\bar\resources;
    use okc\framework\resource;

    class helloWorld extends resource {

      function get() {
        return 'Hello world';
      }

    }
```

Go to http://www.yourapp.local/index.php/hello-world and see hello world message.


Hello world using framework template engine
--------------------------------

* Create packages/foo/bar/views/helloWorld.php template file.
* Update packages/foo/bar/resources/helloWorld.php resource :

```php
    <?php
    namespace foo\bar\resources;
    use okc\framework\resource;
    use okc\framework\view;

    class helloWorld extends resource {

      function get() {
        return new view('okc/example/views/helloWorld.php', array(
          'title' => 'Hello World',
          'content' => 'This is an hello world example',
        ));
      }

    }
```

* add following code in packages/foo/bar/views/helloWorld.php :

```php
    <?php
    // this tell our current template to be rendered inside page.php parent template.
    $this->setParentView('okc/example/page.php');
    ?>

    <h2> <?php print strip_tags($title) ?> </h2>
    <p> <?php print strip_tags($content) ?> </p>
```
Create the packages/foo/bar/views/page.php template in the same directory.

```php
    <h1> MAIN PAGE LAYOUT </h1>

    <?php print $childView ?>
```
$childView is the variable that allow helloWorld.php to be wrapped by page.php template. Variable name may be change using second paramter of setParentView method. 

Display Blocks
--------------

Resource can be used witout any mapping to an url, blocks can be created this way :
This resource use access() method to tell this block to display only on "hello-world" page.

```php
<?php
namespace vendorName\bundleName;

use okc\framework\resource;
use okc\framework\view;
use okc\framework\server;

class contactBlock extends resource {

  function access() {
    if (server::getRouteFromUrl() == 'hello-world') {
      return TRUE;
    }
    return FALSE;
  }

  function get() {
    return new view('vendorName/bundleName/views/fiche-contact.php');
  }

}
```

To display resource, call it somewhere in a page template :
always use "render" method because it takes care of checking access conditions.

```php
  <?php 
  $resource = new vendorName\bundleName\contactBlock(); 
  echo $resource->render();
  ?>
```

Routes pattern
------

To access a resource, you will have to type this kind of url in your brower
http://www.yourapp.local/index.php/myPath

"myPath" is the internal path used by the framework, that's to say framework only care about what come after "index.php".

If you need params in the url, well just use classic get parameters and the use plain old php to catch them in your resource. 

```
http://www.yourapp.local/index.php/hello?id=3
```

Events & listeners manager
-------------------------

An simple events & listeners system is available. Rename config/example.listeners.php to config/listeners.php to register your listeners.
Classes will have to implement a method with the exact event name.
Core framework only provide two events for now :
* frameworkBootstrap
* frameworkShutdown

This allow to add some code to be executed at start or end of the application wihout having to hack index.php file. (database connection, session etc)

Custom events may be fired this way. No convention to name events, it just have to be a string. Params will be passed by reference.

```php
    <?php
    okc\framework\eventsManager::fire('mypackageEvent', array('param' => $myparam));
    ?>
```

