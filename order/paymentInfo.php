<?php
include '../base.php';
auth("Member");

$id = getOrderId();

// Display user payment card and address
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
<?php if($u):?>
<button data-get="addresswitpay.php?order_id=<?=$id?>" class="paymentInfobutton">Update</button></td>
<?php endif ?>

<?php if (!$u): ?>
    <button data-get="addresswitpay.php?order_id=<?=$id?>" class="paymentInfobutton">Insert</button>
<?php endif ?>

<?php
include '../foot.php';
