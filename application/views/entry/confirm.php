<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
    <h1>会員登録 - 入力確認</h1>

    <div id="body">
        <?php echo form_open('entry/input'); ?>
            <dl class="cf">
                <dt>ユーザID</dt>
                <dd><?php echo $user_id ?></dd>
                <dt>氏名</dt>
                <dd><?php echo $name1. " ". $name2 ?></dd>
                <dt>氏名カナ(セイ)</dt>
                <dd><?php echo $name1_kana. " ". $name2_kana ?></dd>
                <dt>性別</dt>
                <dd><?php echo $sex_val ?></dd>
                <dt>郵便番号</dt>
                <dd><?php echo $zip1. "-". $zip2 ?></dd>
                <dt>住所</dt>
                <dd><?php echo $pref_val. $address1. $address2 ?></dd>
                <dt>電話番号</dt>
                <dd><?php echo $tel1. "-". $tel2. "-". $tel3 ?></dd>
                <dt>メールアドレス</dt>
                <dd><?php echo $mail ?></dd>
                <dt>パスワード</dt>
                <dd><?php echo $password_val ?></dd>
            </dl>
            <div class="txtC">
                <button type='submit' name='action' value='1'>confirm</button>
            </div>
        </form>
    </div>
</div>
