<?php
use okc\server\server;
$this->setParentView('okc/demo/views/layout.php');
?>

<p>This is the default homepage, provided by <em>packages/okc/framework</em> package. <br/>
To create a new page or customize homepage, copy <em>config/example.routes.php</em> file to <em>config/routes.php</em> and edit routes.php file</p>

<p>
See also <a target="_blank" href="https://github.com/nyl-auster/okc-framework/blob/master/README.md"> online documentation </a> on how to create new resources; or take a look at code from packages/okc/example package and its hello world example.<br/>
</p>
<p>
Hello world example page will be available once you have copy example.routes.php file to routes.php file.
<a href="<?php echo server::getUrlFromRoute('hello-world')?>"> <?php echo server::getUrlFromRoute('hello-world')?></a>
</p>

