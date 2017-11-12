<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
	<h1>ログイン</h1>

	<div id="body">
		<?php echo form_open('login'); ?>
<!--		<form method="post" action="http://h-matsuya.sakura.ne.jp/JobCoordinator/login"> -->
			<dl class="cf">
				<dt>id</dt>
				<dd><?php echo form_input("login_id", $this->input->post("login_id")); ?></dd>
				<dt>password</dt>
				<dd><?php echo form_password("password", $this->input->post("password")); ?></dd>
			</dl>
			<?php echo validation_errors(); ?>
<!--			<?php //if(isset($errMsg)){ echo $errMsg; } ?> -->
			<div class="txtC">
				<button type='submit' name='action' value='1'>login</button>
			</div>
		</form>
	</div>
</div>
