<?php
include '../base.php';

auth("Member");

$p = $_db->prepare("SELECT * FROM `order` WHERE user_id = ? ORDER BY id DESC");
$p->execute([$_user->id]);
$arr = $p->fetchAll();

$_title = 'Order History';
include '../head.php';
?>

<table class="history">
    <tr>
        <th>ID</th>
        <th>DATE</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>More</th>
    </tr>
    <?php foreach ($arr as $h): ?>
        <tr>
            <td><?= $h->id ?></td>
            <td><?= $h->datetime ?></td>
            <td><?= $h->count ?></td>
            <td><?= $h->total ?></td>
            <td> <button data-get="orderdetail.php?id=<?= $h->id ?>">Detail</button></td>
        </tr>
    <?php endforeach ?>
</table>

<?php
include '../foot.php';
