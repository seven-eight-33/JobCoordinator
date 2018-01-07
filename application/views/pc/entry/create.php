<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
    <h1>会員登録 - 本登録完了</h1>

    <div id="body">
        <div>
            <?php if ($checkRes): ?>
                <p>
                    会員本登録が完了しました。<br>
                    下記ボタンからマイページへアクセスし、JobCoordinator を始めてください！
                </p>
                <p><a href="<?php echo $url_mypage ?>">マイページへ</a></p>
            <?php else: ?>
                <p>
                    アクセスした URL が正しくありません。<br>
                    URL を確認し、再度アクセスしてください。
                </p>
                <p><a href="/">トップへ</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
