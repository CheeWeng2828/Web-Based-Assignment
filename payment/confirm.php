<?php
include '../base.php';

$stm = $_db->prepare('INSERT INTO payment (datetime,status,order_id)VALUE (NOW(),PAID,?)');
$stm->execute([$_order->id]);

temp('info','Place Order Successful');
redirect("/");

$_title = "Confirmation";
include '../head.php';
?>


<?php
include '../foot.php';