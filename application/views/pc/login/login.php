<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
    <h1>ログイン</h1>

    <div id="body">
        <?php echo form_open('login'); ?>
            <dl class="cf">
                <dt>id</dt>
                <dd><?php echo form_input("login_id", set_value("login_id")); ?></dd>
                <dt>password</dt>
                <dd><?php echo form_password("password", set_value("password")); ?></dd>
            </dl>
            <?php echo validation_errors(); ?>
            <div class="txtC">
                <button type='submit' name='action' value='1'>login</button>
            </div>
        </form>
    </div>
</div>
