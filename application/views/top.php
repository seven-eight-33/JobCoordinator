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
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
