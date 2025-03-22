<?php
include '../base.php';

auth("Member");

$stm = $_db->prepare('
        SELECT * FROM `order`
        WHERE user_id = ?
        ORDER BY id DESC
');

$stm->execute([$_user->id]);
$arr = $stm->fetchAll();

$_title = 'Order History';
include '../head.php';
?>

<table class="history">
    <tr>
        <th>ID</th>
        <th>Date Time</th>
        <th>Count</th>
        <th>Total(RM)</th>
    </tr>
    <?php foreach($arr as $h):?>
        <tr>
            <td><?=$h->id?></td>
            <td><?=$h->datetime?></td>
            <td><?=$h->count?></td>
            <td><?=$h->total?></td>
        </tr>
        <tr>
            <button data-get="orderdetail.php?id=<?= $h->id?>">Detail</button>
        </tr>
        <?php endforeach?>
</table>

<?php
include '../foot.php';