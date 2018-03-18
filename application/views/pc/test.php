<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container">
    <h1>testページ!</h1>

    <div id="body">
        <p>test_contents！</p>
        <?php foreach ($results as $schedule): ?>
            <p><?php echo $schedule['start']; ?>：<?php echo $schedule['summary']; ?></p>
        <?php endforeach; ?>
    </div>
</div>
