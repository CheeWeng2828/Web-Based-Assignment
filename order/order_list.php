<?php
require '../base.php';
$fields = [
    'id'         => 'Id',
    'datetime'      => 'Date Time',
    'count'       => 'Quantity',
    'total'       => 'Total Amount(RM)',
    'user_id'       => 'User_id'
];

$arr = $_db->query('SELECT * FROM `order`')->fetchAll();

$_title = "Order List";
include '../head.php';
?>

<table class="orderList">
    <tr>
        <th>Id</th>
        <th>Date Time</th>
        <th>Quantity</th>
        <th>Total Amount(RM)</th>
        <th>User_id</th>
    </tr>

    <?php foreach ($arr as $s) : ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->datetime ?></td>
            <td><?= $s->count ?></td>
            <td><?= $s->total ?></td>
            <td><?= $s->user_id ?></td>
        <?php endforeach ?>
        </tr>
</table>

<?php
include '../foot.php';