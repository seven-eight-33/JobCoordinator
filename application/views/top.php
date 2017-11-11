<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
	<h1>トップページ!</h1>

	<div id="body">
		<p>top調整成功！</p>
	</div>
	<?php foreach ($result as $results): ?>
	  <p><?php echo $results->NAME1; ?></p>
	<?php endforeach; ?>
</div>
