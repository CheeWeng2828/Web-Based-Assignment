<?php
include '../base.php';
auth();
$id = req('id');

if (is_post()) {
    $status = req('orderStatus');
    $stm = $_db->prepare("UPDATE payment SET status = ? WHERE order_id = ?");
    $stm->execute([$status, $id]);

    temp('info', 'Update Status Successful');
    redirect('order_list.php');
}
$stm = $_db->prepare('
SELECT * FROM `order`
WHERE id = ?
');

$stm->execute([$id]);
$o = $stm->fetch();
if (!$o) redirect('history.php');


$stm = $_db->prepare('
SELECT i.*,p.name,p.photo,y.datetime,y.status
FROM item AS i LEFT JOIN payment AS y
ON i.order_id = y.order_id
JOIN product AS p
ON i.product_id = p.id
WHERE i.order_id = ?
');
$stm->execute([$id]);
$arr = $stm->fetchAll();

$stm = $_db->prepare('SELECT status FROM payment WHERE order_id = ?');
$stm->execute([$id]);
$status = $stm->fetch();

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
        <?php foreach ($status as $s): ?>
            <?php if ($_user?->role == "Admin" && $s != "CANCEL"): ?>
                <th>Status</th>
                <th>
                    <form method="post">
                        <?= html_select('orderStatus', $_orderStatus, $s) ?>
                        <button class="statusSub">Submit</button>
                    </form>
                <?php endif ?>
                </th>
                <?php if ($_user?->role == "Admin" && $s == "CANCEL"): ?>
                    <th>Status</th>
                    <td><?= $s ?></td>
                <?php endif ?>
            <?php endforeach ?>
    </table>
    <table class="detail">
        <tr>
            <?php if ($_user?->role == "Member"): ?>
                <th>Status</th>
                <?php foreach ($status as $s): ?>
                    <td><?= $s ?></td>
                <?php endforeach ?>
            <?php endif ?>
        </tr>
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
    <?php if ($_user?->role == "Member" && $h->status != "PENDING"): ?>
        <button class="reorder" data-get="reorder.php?id=<?= $id ?>">Reorder</button>
    <?php endif ?>
    <?php if ($h->status != "CANCEL" && $h->status != "READY TO SHIP" && $h->status != "DELIVERED"): ?>
        <button class="cancel" data-get="cancelOrder.php?id=<?= $id ?>">Cancel Order</button>
    <?php endif ?>
    <?php if ($_user?->role == "Member" && $h->status == "PENDING"): ?>
        <button class="pending" data-get="payment.php?order_id=<?= $id ?>">Make Payment</button>
    <?php endif ?>

</div>
<?php
include '../foot.php';
