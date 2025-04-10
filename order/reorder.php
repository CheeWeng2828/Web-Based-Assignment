<?php
include '../base.php';

$id = req('id');

$_db->beginTransaction();

$stm = $_db->prepare('
INSERT INTO `order` (datetime,user_id)
VALUES (NOW(),?)
');
$stm->execute([$_user->id]);
$id = $_db->lastInsertId();

/////

$stm = $_db->prepare('
INSERT INTO item(order_id,product_id,price,unit,subtotal)
VALUES (?,?,(SELECT price FROM product WHERE id = ?),?,price * unit)
');


$stm = $_db->prepare('
UPDATE `order`
SET count = (SELECT SUM(unit) FROM item WHERE order_id = ?),
    total = (SELECT SUM(subtotal)FROM item WHERE order_id = ?)
    WHERE id = ?
');

$stm->execute([$id, $id, $id]);

$stm = $_db->prepare('
UPDATE `inventory`
SET `quantity` = `quantity` - ?
WHERE `product_id` = ?
');
foreach ($cart as $product_id => $unit) {
    $stm->execute([$unit,$product_id]);
}

/////
$stm = $_db->prepare('SELECT * FROM `order` WHERE id = ?');
$stm->execute([$id]);
$order = $stm->fetch();
order($order);
////

/////
$stm = $_db->prepare("
INSERT INTO payment (datetime,status,order_id)
VALUE (NOW(),'PENDING',?)");
$stm->execute([$id]);
/////

$_db->commit();
temp('info', 'Make Order Successful');
redirect("payment.php");

$_title = "Reorder";
include '../head.php';
?>

<?php
include '../foot.php';