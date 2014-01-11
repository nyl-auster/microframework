<?php
use okc\server\server;
use okc\config\config;
$this->setParentView('packages/okc/demo/views/layout.php');
$routes = config::get('routes');
?>

<table>
<tr>
<th> Route </th>
<th> Link </th>
<th> class </th>
</tr>
<?php foreach ($routes as $path => $datas) : ?>
<tr>
  <td><?php print $path;?></td>
  <td><?php print server::link($path, $path);?></td>
  <td><?php print $datas['class'];?></td>
</tr>
<?php endforeach ?>
</table>

