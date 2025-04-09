<?php
include '../base.php';

$id = req('id');
$stm = $_db->prepare('
SELECT * FROM `order`
WHERE id = ?
');

$stm->execute([$id]);
$o = $stm->fetch();
if (!$o) redirect('history.php');

$stm = $_db->prepare('
SELECT i.*,p.name,p.photo,y.datetime,y.status
FROM item AS i JOIN payment AS y
ON i.order_id = y.order_id
JOIN product AS p
ON i.product_id = p.id
WHERE i.order_id = ?
');
$stm->execute([$id]);
$arr = $stm->fetchAll();


$_title = "Order Detail";
include '../head.php';
?>
<form class="OrderDetail">
    <label>Order Id:</label>
    <b><?= $o->id ?></b>
    <br>

    <label>Date Time:</label>
    <?= $o->datetime ?>
    <br>

    <label>Count:</label>
    <?= $o->count ?>
    <br>

    <label>Total:</label>
    RM <?= $o->total ?>
    <br>
</form>
<div class="detail-table-container">
    <table class="detail">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price (RM)</th>
            <th>Unit</th>
            <th>Subtotal (RM)</th>
            <th>Date Time</th>
            <th>Status</th>
        </tr>

        <?php foreach ($arr as $h): ?>
            <tr>
                <td><?= $h->product_id ?></td>
                <td><?= $h->name ?></td>
                <td><?= $h->price ?></td>
                <td><?= $h->unit ?></td>
                <td><?= $h->subtotal ?></td>
                <td><?= $h->datetime ?></td>
                <td><?= $h->status ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<?php
include '../foot.php';
