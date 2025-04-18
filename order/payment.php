<?php
include '../base.php';
auth("Member");
$id = req('order_id');

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
    $itemsStr .= $d->name . "<br>" . "Quantity: " . $d->unit . "<br>Price:  " . $d->price . "<br>";
}

$m = get_mail();

$url = base("order/confirm.php?order_id= " . $id);
$m->addAddress($_user->email, $_user->name);
$m->addEmbeddedImage("../photo/$_user->photo",'photo');
$m->isHTML(true);
$m->Subject = 'Payment Confirmation';
$m->Body = "
            <img src='cid:photo'
            style='width: 50px; height: 50px;
            border: 1px solid #333'>
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
