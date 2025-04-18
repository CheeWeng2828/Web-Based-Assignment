<?php
include '../base.php';

$id = req('id');

$stm = $_db->prepare("UPDATE payment SET status ='CANCEL' WHERE order_id = ?");
$stm->execute([$id]);

$unit = $_db->prepare('SELECT * FROM item WHERE order_id = ?');
$unit->execute([$id]);
$i = $unit->fetchAll();
$inv = $_db->prepare('UPDATE inventory SET quantity = quantity + ? WHERE product_id = ?');
foreach ($i as $item) {
    $inv->execute([$item->unit, $item->product_id]);
}

temp('info', 'Cancel Successful');
redirect('/');

include '../head.php';
$_title = "Cancel Order";
?>

<?php
include '../foot.php';
