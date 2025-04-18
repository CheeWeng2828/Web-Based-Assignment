<?php
include '../base.php';
auth("Member");

$_title = 'Payment Info';
include '../head.php';
?>

<form method="post" class="paymentInfo">
    <label for='cardNum'>Card Number</label>
    <?= html_text('cardNum') ?>
    <?= err('cardNum') ?>

</form>

<?php
include '../foot.php';