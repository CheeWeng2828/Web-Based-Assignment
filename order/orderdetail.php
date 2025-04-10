<?php
include '../base.php';

$id = req('id');

if (is_post()) {
    $status = req('status');
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
        <?php if ($_user?->role == "Admin"): ?>
            <th>Status</th>
            <th>
                <form method="post">
                    <?= html_select('status', $_orderStatus) ?>
            <th>
                <section>
                    <button>Submit</button>
                </section>
            </th>
            </form>
        <?php endif ?>
    </table>
    <table class="detail">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price (RM)</th>
            <th>Unit</th>
            <th>Subtotal (RM)</th>
            <?php if ($_user?->role == "Member"): ?>
                <th>Status</th>
            <?php endif ?>
            <th>More</th>

        </tr>

        <?php foreach ($arr as $h): ?>
            <tr>
                <td><?= $h->product_id ?></td>
                <td><?= $h->name ?></td>
                <td><?= $h->price ?></td>
                <td><?= $h->unit ?></td>
                <td><?= $h->subtotal ?></td>
                <?php if ($_user?->role == "Member"): ?>
                    <th><?= $h->status ?></th>
                    <?php if ($h->status == "Cancel"): ?>
                        <td> <button data-get="cancelOrder.php?id=<?= $h->order_id ?>">Cancel Order</button></td>
                    <?php endif ?>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
    </table>

</div>
<?php
include '../foot.php';
