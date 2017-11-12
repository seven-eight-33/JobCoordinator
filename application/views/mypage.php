<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
	<h1>MYページ</h1>

	<div id="body">
		<p>mypage調整成功！</p>
	</div>
	<?php foreach ($result as $results): ?>
	  <p><?php echo $results->NAME1; ?></p>
	<?php endforeach; ?>
	<form method="post" action="http://h-matsuya.sakura.ne.jp/JobCoordinator/">
		<input name="LOGIN_ID" type="text" value="" />
		<button type='submit' name='action' value='1'>login</button>
	</form>
</div>
