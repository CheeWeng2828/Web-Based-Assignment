<?php
include '../base.php';

$id = req('id');

$stm = $_db->prepare('SELECT * FROM `order`WHERE id = ?');
$stm->execute([$id]);

$m = get_mail();

$url = base("order/orderdetail.php?id=$id");
$m->addAddress($u->email, $u->name);
$m->isHTML(true);
$m->Subject = 'Order Detail';
$m->Body = "
            <p>Dear $u->name,<p>
            <h1>Order Detail</h1>
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



<?php
include '../foot.php';
