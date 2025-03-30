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
SELECT i.*,p.name,p.photo
FROM item AS i,product AS p
WHERE i.product_id = p.id
AND i.order_id = ?
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

<table class="Detail">
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Price (RM)</th>
        <th>Unit</th>
        <th>Subtotal (RM)</th>
    </tr>

    <?php foreach ($arr as $h): ?>
        <tr>
            <td><?= $h->product_id ?></td>
            <td><?= $h->name ?></td>
            <td><?= $h->price ?></td>
            <td><?= $h->unit ?></td>
            <td><?= $h->subtotal ?></td>
        </tr>
    <?php endforeach ?>
</table>
<?php
include '../foot.php';
