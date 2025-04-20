<?php
include '../base.php';
auth("Member");

$order_id = req('order_id');

$userInfo = $_db->prepare('SELECT * FROM user_payment WHERE user_id = ?');
$userInfo->execute([$_user->id]);
$u = $userInfo->fetchAll();

$_title = 'Payment Method Detail';
include '../head.php';
?>

<table class="paymentInfo">

    <tr>
        <th>Address</th>
        <th>Card Number</th>
    </tr>
    <?php foreach ($u as $p): ?>

        <tr>
            <td><?= $p->address ?></td>
            <td><?= $p->card_no ?></td>
        </tr>

    <?php endforeach ?>

</table>

<button data-get="addresswitpay.php?order_id=<?= $order_id ?>">Update</button></td>

<?php if ($order_id): ?>
    <button data-get="payment.php?order_id=<?= $order_id ?>">Confirm</button>
<?php endif ?>


<?php
include '../foot.php';
