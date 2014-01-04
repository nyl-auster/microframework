OKC framework
==============

OKC framework is a slim View-Controller php framework.

Requirements
------------
* Php >= 5.3
* Apache

Features
---------
* Build your app with resources rather than "controllers". A resource is a class that represents a piece of content of your app / site; providing methods to customize its behavior. A "page" may be seen as a collection of ressources gathered in a special layout.
* Basic router : map an url to a resource with routes.php file to create web page. 
* Parent and children views : a template may be wrapped by any other templates and overrides parent template variables if needed.
* Basic event listeners system : call custom php callable on core or custom events.
* PSR-0 standard : you may use any php class or libary implementing PSR-0 in your project.
* Customize 404 and 403 pages with resource of your own.
* Settings file for your configuration.

Documentation
==============

Installation
-------------

Clone the git repository.
rename config/example.routes.php file to config/routes.php to create new routes, following documentation below.


Quickstart : Hello World
------------------------

Rename config/example.routes.php to routes.php
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


Resources
---------

Custom resources classes *must* extends core abstract resource class and must at least implements the "get" method,
this is the default method to render a resource and this method will be called on http get request automatically when calling a resource from an url.
Each resource may implements an access methods to decide if this resource should be displayed to the user or not. When the resource is mapped to an url, returning FALSE in this method will throw a 403 http response code.

Routes
------

To access a resource, you will have to type this kind of url in your brower
http://www.yourapp.local/index.php/myPath

"myPath" is the internal path used by the framework, that's to say framework only care about what come after "index.php".

If you need params in the url, well just use get parameters like this and then use pure php to get them in your resource. No abstractions for that part, just php.
http://www.yourapp.local/index.php/hello?id=3

Autoloader
------------

PSR-0 is used for autoloading. Put your classes in vendor or modules directory.

Listeners
---------

A basic listener system is available. See config/example.listeners.php file.
You can map a php callable to an event with this file. Only two events are provided by core for now
* okc.bootstrap
* okc.shutdown

This allow you to add some code to be executed at start or end of the application wihout having to hack index.php file
You may fire your own events this way. There is no convention to name events, it just have to be a string :

```php
    <?php
    $eventsManager = eventsManager::getInstance($listeners);
    $eventsManager->fire('mymodule.myevent', array('param' => $params));
    ?>
```

