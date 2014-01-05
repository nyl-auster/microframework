<?php
use okc\framework\server;
global $routes;
?>

<html>
  <head>
    <title> OKC FRAMEWORK </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link href="<?php echo server::$basePath ?>packages/okc/framework/views/style.css" rel="stylesheet"/>
  </head>
<body>
  <header>
    <div id="marque">

      <div id="marque-1">
        <div class="letter" id="letter-O">O</div>
        <div class="letter" id="letter-K">K</div>
        <div class="letter" id="letter-C">C</div>
      </div>

      <div id="marque-2">
      Framework
      </div>

      <div id="slogan">
        <p id="phrase-1"> Light view-controller PHP Framework </p>
      </div>

    </div>
  </header>

<div id="wrapper">

<p>This is the default homepage, provided by <em>packages/okc/framework</em> package. <br/>
To create a new page or customize homepage, copy <em>config/example.routes.php</em> file to <em>config/routes.php</em> and edit routes.php file</p>

<p>
See also <a target="_blank" href="https://github.com/nyl-auster/okc-framework/blob/master/README.md"> online documentation </a> on how to create new resources; or take a look at code from packages/okc/example package and its hello world example.<br/>
</p>
<p>
Hello world example page : 
<a href="<?php echo server::getUrlFromRoute('hello-world')?>"> <?php echo server::getUrlFromRoute('hello-world')?></a>
</p>
</div>

</body>
</html>

