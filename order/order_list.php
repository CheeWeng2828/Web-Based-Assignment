<?php
include '../base.php';
//-----------------------------------------------------------------------------

// (1) Sorting
$fields = [
    'id' => 'ID',
    'datetime' => 'Date Time',
    'count' => "Quantity",
    'total' => 'Total Amount(RM)',
    'user_id' => 'User_id',
];

$sort = req('sort');
key_exists($sort, $fields) || $sort = 'id';

$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';

// (2) Paging
$page = req('page', 1);

require_once '../lib/SimplePager.php';
$p = new SimplePager("SELECT * FROM `order` ORDER BY $sort $dir", [], 10, $page);
$arr = $p->result;


// ----------------------------------------------------------------------------
$_title = 'Order List';
include '../head.php';
?>

<p>
    <?= $p->count ?> of <?= $p->item_count ?> record(s) |
    Page <?= $p->page ?> of <?= $p->page_count ?>
</p>

<table class="orderList">
    <tr>

        <?= table_headers($fields, $sort, $dir, "page=$page") ?>
    </tr>

    <?php foreach ($arr as $s): ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->datetime ?></td>
            <td><?= $s->count ?></td>
            <td><?= $s->total ?></td>
            <td><?= $s->user_id ?></td>
        </tr>
    <?php endforeach ?>
</table>

<br>
<div class="pager">
<?= $p->html("sort=$sort&dir=$dir",) ?>
</div>
<?php
include '../foot.php';
