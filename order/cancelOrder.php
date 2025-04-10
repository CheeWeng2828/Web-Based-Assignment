<?php
include '../base.php';

$id = req('id');

$stm = $_db->prepare("UPDATE payment SET status ='CANCEL' WHERE order_id = ?");
$stm->execute([$id]);

temp('info','Cancel Successful');
redirect('/');

include '../head.php';
$_title = "Cancel Order";
?>

<?php
include '../foot.php';