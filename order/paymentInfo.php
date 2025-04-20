<?php
include '../base.php';
auth("Member");

$userInfo = $_db->prepare('SELECT * FROM user_payment WHERE user_id = ?');
$userInfo->execute([$_user->id]);
$u = $userInfo->fetchAll();

$_title = 'Payment Info';
include '../head.php';
?>

<table class="paymentInfo">

<tr>
        <!-- <th>Address</th> -->
        <th>Card Number</th>
    </tr>
<?php foreach($u as $p): ?> 
   
    <tr>
        <!-- <td><?= $p->address ?></td> -->
        <td><?= $p->card_no ?></td>
    </tr>

<?php endforeach ?>

</table>

<?php
include '../foot.php';