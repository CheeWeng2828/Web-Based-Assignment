<?php
include '../base.php';

$id = $_order->id;

$stm = $_db->prepare('SELECT * FROM `order`WHERE id = ?');
$stm->execute([$id]);
$p = $stm->fetch();

$stm2 = $_db->prepare('SELECT p.name,i.unit,i.price,i.subtotal 
                       FROM product AS p JOIN item AS i 
                       ON p.id = i.product_id 
                       WHERE i.order_id = ?
                       ');

$stm2->execute([$id]);
$n = $stm2->fetchAll();


$itemsStr = "";
foreach ($n as $d) {
    // Concatenate product name and unit with a line break.
    $itemsStr.= $d->name ."<br>"."Quantity: ".$d->unit."<br>Price:  ".$d->price;
}

$m = get_mail();

$url = base("order/confirm.php");
$m->addAddress($_user->email, $_user->name);
$m->isHTML(true);
$m->Subject = 'Payment Confirmation';
$m->Body = "
            <p>Dear $_user->name,<p>
            <h1>Order Detail</h1>
            <p>
            Order ID:   $p->id <br>
            Item:
            </p>
            <p>
            $itemsStr
            </p>
            <p>
            Total Price:    RM$p->total
            <p>
                Please click <a href='$url'>here</a>
                for more detail.
            </p>
            <p>From, 🍞 Admin</p>
        ";
$m->send();

$_title = 'Payment';
include '../head.php';
?>

<p>Please Check Your Mail Box To Confirm The Payment</p>

<?php
include '../foot.php';
