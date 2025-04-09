<?php
include '../base.php';

$id = $_order->id;

$stm = $_db->prepare('SELECT * FROM `order`WHERE id = ?');
$stm->execute([$id]);
$p = $stm->fetch();

$stm2 = $_db->prepare('SELECT p.name,i.unit FROM product AS p JOIN item AS i ON p.id = i.product_id WHERE i.order_id = ?');
$stm2->execute([$id]);
$n = $stm2->fetch();

$m = get_mail();

$url = base("payment/confirm.php?id=$id");
$m->addAddress($u->email, $u->name);
$m->isHTML(true);
$m->Subject = 'Order Detail';
$m->Body = "
            <p>Dear $u->name,<p>
            <h1>Order Detail</h1>
            <p>
            Order ID:   $p->id
            Item:
            </p>
            <p>
            <?=foreach($n as $d)?>
            $d->name    $d->unit
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
