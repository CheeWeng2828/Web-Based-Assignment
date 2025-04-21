<?php
include '../base.php';

auth("Member");

if (is_post()) {

    $cart = get_cart();
    if (!$cart) redirect('shopping_cart.php');

    $_db->beginTransaction();

    $stm = $_db->prepare('
    INSERT INTO `order` (datetime,user_id)
    VALUES (NOW(),?)
    ');

    $stm->execute([$_user->id]);
    $id = $_db->lastInsertId();

    setOrderID($id);

    $stm = $_db->prepare('
    INSERT INTO item(order_id,product_id,price,unit,subtotal)
    VALUES (?,?,(SELECT price FROM product WHERE id = ?),?,price * unit)
    ');

    foreach ($cart as $product_id => $unit) {
        $stm->execute([$id, $product_id, $product_id, $unit]);
    }

    $stm = $_db->prepare('
    UPDATE `order`
    SET count = (SELECT SUM(unit) FROM item WHERE order_id = ?),
        total = (SELECT SUM(subtotal)FROM item WHERE order_id = ?)
        WHERE id = ?
    ');

    $stm->execute([$id, $id, $id]);

    // Update the product stock quantity to latest
    $stm = $_db->prepare('
    UPDATE `product`
    SET `stock` = `stock` - ?
    WHERE `id` = ?
    ');
    foreach ($cart as $product_id => $unit) {
        $stm->execute([$unit,$product_id]);
    }

    // Insert the payment status to Pending when order place
    $stm = $_db->prepare("
    INSERT INTO payment (datetime,status,order_id)
    VALUE (NOW(),'PENDING',?)");
    $stm->execute([$id]);

    $_db->commit();

    set_cart();
    temp('info', 'Make Order Successful,Please Insert Your Payment Detail');
    redirect("paymentInfo.php?order_id=" . $id);
}

redirect('cart.php');

$_title = "Check Out";
include '../head.php';
?>
<?php
include '../foot.php';
