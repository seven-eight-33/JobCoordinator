<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
	<h1>ログイン</h1>

	<div id="body">
		<form method="post" action="http://h-matsuya.sakura.ne.jp/JobCoordinator/login">
			<dl class="cf">
				<dt>id</dt>
				<dd><input name="login_id" type="text" maxlength="20" value="<?php $login_id ?>" /></dd>
				<dt>password</dt>
				<dd><input name="password" type="password" maxlength="20" value="<?php $password ?>" /></dd>
			</dl>
			<?php echo $errMsg; ?>
			<div class="txtC">
				<button type='submit' name='action' value='1'>login</button>
			</div>
		</form>
	</div>
</div>
