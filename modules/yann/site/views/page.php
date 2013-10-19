<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
<div id="titresite"> Example site </div>
</header>

<div id="wrapper">
<?php 
$menu = new yann\site\ressources\menu();
print $menu->render();
?>

<!-- ressource template -->
<?php print $innerView ?>


<?php
$footer = new yann\site\ressources\footer();
print $footer->render();
?>

</div>
</html>
</body>

