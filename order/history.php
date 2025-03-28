<?php
include '../base.php';

auth("Member");

$fields = [
    'id' => 'ID',
    'datetime' => 'Date Time',
    'count' => "Quantity",
    'total' => 'Total Amount(RM)',
];

$sort = req('sort');
key_exists($sort, $fields) || $sort = 'id';

$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';

$page = req('page', 1);

require_once '../lib/SimplePager.php';
$p = new SimplePager("SELECT * FROM `order` ORDER BY $sort $dir", [], 5, $page);
$arr = $p->result;

$_title = 'Order History';
include '../head.php';
?>
<p>
    <?= $p->count ?> of <?= $p->item_count ?> record(s) |
    Page <?= $p->page ?> of <?= $p->page_count ?>
</p>
<table class="history">
    <tr>
        <?= table_headers($fields, $sort, $dir, "page=$page") ?>
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

<br>
<div class="pager">
    <?= $p->html("sort=$sort&dir=$dir",) ?>

    <?php
    include '../foot.php';
