OKC framework
==============

OKC framework is a tiny View-Controller php framework, built around "resource" concept to display and generate pieces of content.

Requirements
------------
* Php >= 5.3
* Apache

Features
---------
* Build your app around resources. A resource is a class that represents any piece of content of your application; providing methods to customize its behavior and visibility. They may be used to create blocks, pages, rss, xml, json etc...
* Basic router : map an url to a resource with routes.php file to create a web page. 
* Parent and children template / views : a template may be wrapped by any other template and overrides parent template variables if needed.
* Basic events manager : subscribe to core events with php callables or create custom events.
* PSR-0 standard : you may use any php class or libary implementing PSR-0 in your project.
* Customize 404 and 403 pages with resources of your own.
* Settings file for holding configuration.
* Aside from resource concept, no abstractions are provided: okc framework is plain old php.

Documentation
==============


Installation
-------------

Clone the git repository.
Rename config/example.routes.php file to config/routes.php to create new routes.

Directory structure
-------------------

Custom and core code resides in "bundles" directory. Structure should include a vendor name and then a bundle name :
   bundles/{yourVendorName}/{yourBundleName}/ your custom classes here.
Framework code resides in bundles/okc/framework folder.

Example module
--------------

Take a look at bundles/okc/example bundle to see how to organize custom code. Rename example.routes.php to routes.php in config folder and uncomment this line to visite the example page.
   # include 'okc/example/config/routes.php';

Quickstart : Hello World
------------------------

Rename config/example.routes.php to config/routes.php
Create a new route for our "helloWorld" resource in config/routes.php. Key will be the new available url and "class" will contain namespace of the class to use

```php
  $routes['hello-world'] = array('class' => 'okc\example\helloWorld');
```

Create a new bundle called "example" in "okc" directory.
Create a new php file call helloWorld.php with following content :

```php
    <?php
    // define our namespace to allow PSR-0 autoload
    namespace okc\example;
    // use abstract resource class provided by the framework
    use okc\framework\resource;

    /**
     * Say hello to the world.
     */
    class helloWorld extends resource {

      /**
       * This method will be automatically called by the framework when visiting "hello-world" url.
       */
      function get() {
        return 'Hello world';
      }

    }
```

Go to http://www.yourapp.local/index.php/hello-world and see hello world message.


Hello world with template system
--------------------------------

Display the hello world with template system. Add
    use okc\framework\view
At the top of our file. And return a view object at the end of the get method rather than a string :

```php
    <?php
    namespace okc\example;

    use okc\framework\resource;
    // add template system provided by the framework
    use okc\framework\view;

    class helloWorld extends resource {

      function get() {
        // define some variables we want to use in the template.
        // Usefull only for dynamic datas.
        $variables = array(
          'title' => 'Hello World',
          'content' => 'This is an hello world example',
        );
        // add path to the template we want to use. This the full relative path.
        return new view('okc/example/helloWorldView.php', $variables);
      }

    }
```

Create the helloWordView.php template in okc/example with following content

```php
    <?php
    // our helloWorldView.php template will be included in page.php template adding this line :
    $this->setParentView('okc/example/page.php');
    ?>

    <h2> <?php print strip_tags($title) ?> </h2>
    <p> <?php print strip_tags($content) ?> </p>
```
Create the page.php template in the same directory.

```php
    <h1> PAGE LAYOUT </h1>

    <?php print $childView ?>
```

Do not forget $childView or helloWordView.php won't be displayed at all.
$childView is the default variable name for child templates, but you may change the variable name using second param of setParentView method. Here we create a variable "helloWorldView" instead of "childView".
    $this->setParentView('okc/example/page.php', 'helloWordView');

Page.php could set a parent too, there is no limit for parent / children imbrication of templates.

Display Blocks
--------------

Resource can be used witout any mapping to an url, blocks can be created this way :
This resource use access method to tell this block to display only on "hello-world" page.

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
always use "render" method because it take care of checking access conditions.

```php
  <?php 
  $resource = new vendorName\bundleName\contactBlock(); 
  echo $resource->render();
  ?>
```

Resources
---------

Custom resources classes *must* extends core abstract resource class and must at least implements the "get" method,
this is the default method to render a resource and this method will be called on http get request automatically when calling a resource from an url.
Each resource may implements an access methods to decide if this resource should be displayed to the user or not. When the resource is mapped to an url, returning FALSE in this method will throw a 403 http response code.
Nether call get() method yourself, use render() method instead if you call manually a resource, as it take care of access control.

Routes pattern
------

To access a resource, you will have to type this kind of url in your brower
http://www.yourapp.local/index.php/myPath

"myPath" is the internal path used by the framework, that's to say framework only care about what come after "index.php".

If you need params in the url, well just use get parameters like this and then use pure php to get them in your resource. No abstractions for that part, just php.
http://www.yourapp.local/index.php/hello?id=3

Autoloader
------------

PSR-0 is used for autoloading. Simply put your classes in bundles directory.

Events & listener manager
---------

An simple events & listeners system is available. Rename config/example.listeners.php to config/listeners.php to register your listeners.
You can map a class to an event with this file. Class will have to implement a method with the event name.
Core framework only provide two events for now :
* frameworkBootstrap
* frameworkShutdown

This allow you to add some code to be executed at start or end of the application wihout having to hack index.php file. (database connection, session etc)

You may fire your own events this way. There is no convention to name events, it just have to be a string :

```php
    <?php
    okc\framework\eventsManager::fire('mybundleMyevent', array('param' => $params));
    ?>
```

