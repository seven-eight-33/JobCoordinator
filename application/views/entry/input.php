<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
    <h1>会員登録</h1>

    <div id="body">
        <?php echo form_open('entry/input'); ?>
            <dl class="cf">
                <dt>ユーザID</dt>
                <dd>
                    <input type="text" name="user_id" value="<?php echo set_value("user_id") ?>">
                    <?php echo form_error('user_id', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>氏名(姓)</dt>
                <dd>
                    <input type="text" name="name1" value="<?php echo set_value("name1") ?>">
                    <?php echo form_error('name1', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>氏名(名)</dt>
                <dd>
                    <input type="text" name="name2" value="<?php echo set_value("name2") ?>">
                    <?php echo form_error('name2', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>氏名カナ(セイ)</dt>
                <dd>
                    <input type="text" name="name1_kana" value="<?php echo set_value("name1_kana") ?>">
                    <?php echo form_error('name1_kana', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>氏名カナ(メイ)</dt>
                <dd>
                    <input type="text" name="name2_kana" value="<?php echo set_value("name2_kana") ?>">
                    <?php echo form_error('name2_kana', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>性別</dt>
                <dd>
                    <ul class="sex">
                        <li><label><input id="" type="radio" class="radio" name="sex" value="1" <?php echo set_radio('sex', '1', TRUE); ?>>男性</label></li>
                        <li><label><input id="" type="radio" class="radio" name="sex" value="2" <?php echo set_radio('sex', '2'); ?>>女性<label></li>
                    </ul>
                    <?php echo form_error('sex', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>郵便番号</dt>
                <dd>
                    <input type="text" name="zip1" value="<?php echo set_value("zip1") ?>" maxlength="3">
                    -
                    <input type="text" name="zip2" value="<?php echo set_value("zip2") ?>" maxlength="4">
                    <?php echo form_error('zip1', '<p class="error">', '</p>'); ?>
                    <?php echo form_error('zip2', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>住所</dt>
                <dt>都道府県</dt>
                <dd>
                    <?php echo form_dropdown("pref", $pref_list, $pref); ?>
                    <?php echo form_error('pref', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>市区町村</dt>
                <dd>
                    <input type="text" name="address1" value="<?php echo set_value("address1") ?>">
                    <?php echo form_error('address1', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>番地、建物名</dt>
                <dd>
                    <input type="text" name="address2" value="<?php echo set_value("address2") ?>">
                    <?php echo form_error('address2', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>電話番号</dt>
                <dd>
                    <input type="text" name="tel1" value="<?php echo set_value("tel1") ?>" maxlength="3">
                    -
                    <input type="text" name="tel2" value="<?php echo set_value("tel2") ?>" maxlength="4">
                    -
                    <input type="text" name="tel3" value="<?php echo set_value("tel3") ?>" maxlength="4">
                    <?php echo form_error('tel1', '<p class="error">', '</p>'); ?>
                    <?php echo form_error('tel2', '<p class="error">', '</p>'); ?>
                    <?php echo form_error('tel3', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>メールアドレス</dt>
                <dd>
                    <input type="text" name="mail" value="<?php echo set_value("mail") ?>">
                    <?php echo form_error('mail', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>メールアドレス確認</dt>
                <dd>
                    <input type="text" name="mail_conf" value="<?php echo set_value("mail_conf") ?>">
                    <?php echo form_error('mail_conf', '<p class="error">', '</p>'); ?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    <input type="password" name="password" value="<?php echo set_value("password") ?>">
                    <?php echo form_error('password', '<p class="error">', '</p>'); ?>
                </dd>
            </dl>
            <div class="txtC">
                <button type='submit' name='action' value='1'>entry</button>
            </div>
        </form>
    </div>
</div>
