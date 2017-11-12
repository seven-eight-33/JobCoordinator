<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
	<h1>ログイン</h1>

	<div id="body">
		<form method="post" action="login.php">
			<dl class="cf">
				<dt>id</dt>
				<dd><input name="LOGIN_ID" type="text" maxlength="32" value="$LOGIN_ID" /></dd>
				<dt>password</dt>
				<dd><input name="PASSWORD" type="password" maxlength="32" value="$PASSWORD" /></dd>
			</dl>
			<?php echo $results->errMsg; ?>
			<div class="txtC">
				<button type='submit' name='action' value='1'>login</button>
			</div>
		</form>
	</div>
</div>
