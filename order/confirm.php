<?php
include '../base.php';

auth("Member");

$id = req('order_id');

$stm = $_db->prepare("UPDATE payment SET status = 'PAID' WHERE order_id = ?");
$stm->execute([$id]);
temp('info', 'Place Order Successful');

$_title = "Confirmation";
include '../head.php';
?>

<p>Your Payment Is Make Successful</p>
<p>Click Here For More Information<button data-get="orderdetail.php?id=<?= $id ?>">Detail</button></p>

<?php
include '../foot.php';
