<?php
use okc\server\server;
$this->setParentView('packages/okc/demo/views/layout.php');
global $_routes;
?>

<table>
<tr>
<th> Route </th>
<th> Link </th>
<th> class </th>
</tr>
<?php foreach ($_routes as $path => $datas) : ?>
<tr>
  <td><?php print $path;?></td>
  <td><?php print server::link($path, $path);?></td>
  <td><?php print $datas['class'];?></td>
</tr>
<?php endforeach ?>
</table>
