<?php
use okc\framework\server;
use okc\framework\translator;
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
      <p id="phrase-1"> <?php echo translator::t('light_view_controller_php_framework') ?> </p>
      </div>

    </div>
  </header>

<navigation id="lang">
  <ul>
  <li><?php echo server::link(server::getRouteFromUrl(), translator::t('french'), array('language' => 'fr')) ?> </li>
  <li><?php echo server::link(server::getRouteFromUrl(), translator::t('english'), array('language' => 'en')) ?> </li>
  </ul>
</navigation>

<div id="wrapper">

  <?php echo $childView ?>

</div>

</body>
</html>

