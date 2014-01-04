Microframework is a tiny view-controller php framework.
This is build on "resource" concept : each piece of content is handle by a "resource" class.
A resource may be mapped to an url or may be called directly from where you want in the code.

Requirements
------------

Php >= 5.3, Apache.

Resources
---------

Custom resources classes *must* extends core abstract resource class and must at least implements the "get" method,
this is the default method to render a resource and this method will be called on http get request automatically when calling a resource from an url.

Here a simple example of a resource : it used a file to include some content and a template to render the result.
Example resource :

  <?php
  namespace mybundle\site\example;
  use microframework\core\resource;
  use microframework\core\view;

  class homepage extends resource {

    function get() {
      $variables = array(
        'content' => 'je suis la homepage',
        'title' => 'homepage',
      );
      return new view('yann/site/views/homepage.php', $variables);
    }

  }
  ?>

To map this resource to an url, we now need to create a route.

Routes
------

To create a new page, resource must be accessible by url.
You have to declare a route for that. Open config file, rename example.routes.php to routes.php and create a route for your resource.
This is a basic route that will serve exampleresource on "hello" url :

  <?php
  // hello is the "url" of the resource, "class" is the namespace of the resource class.
  $routes['hello'] = array('class' => 'myBundle\myModule\exampleresource');

To access this resource, you will have to type this url in your brower
http://www.yourapp.local/index.php/hello


Autoloader
------------

PSR-0 is used for autoloading. Put your classes in vendor or modules directory.

Views
-----

Views are used to render html or final representation of a resource.
a view may be a child of another view : here our template will be put inside "page.php" template.
Page.php could also be a child a another template if needed.


  <?php
  $this->setWrapperView('mybundle/site/views/page.php');
  ?>

  <h1> <?php print $title ?> </h1>
  <article>
  <?php print $content ?> 

  </article>



