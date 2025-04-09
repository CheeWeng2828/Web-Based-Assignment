<?php
include '../base.php';

$stm = $_db->prepare("UPDATE payment SET status = 'PAID' WHERE order_id = ?");
$stm->execute([$_order->id]);
temp('info', 'Place Order Successful');

$_title = "Confirmation";
include '../head.php';
?>

<p>Your Payment Is Make Successful</p>
<p>Click Here For More Information<button data-get="orderdetail.php?id=<?= $_order->id ?>">Detail</button></p>

<?php
include '../foot.php';
