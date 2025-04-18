<?php
include '../base.php';


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