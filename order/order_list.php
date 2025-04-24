<?php
include '../base.php';
//-----------------------------------------------------------------------------
auth("Admin");

// Searching Function
$search = req('search');
$search_sql = $search ? "WHERE o.id LIKE ? OR o.user_id LIKE ? OR p.status LIKE ?" : "";
$params = $search ? ["%$search", "%$search", "%$search"] : [];

// (1) Sorting
$fields = [
    'o.id' => 'ID',
    'o.datetime' => 'Date Time',
    'o.count' => "Quantity",
    'o.total' => 'Total Amount(RM)',
    'o.user_id' => 'User_Id',
    'p.status' => 'Order Status'
];

$sort = req('sort');
key_exists($sort, $fields) || $sort = 'o.id';

$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';

// (2) Paging
$page = req('page', 1);

// For sorting purpose
$sql = "SELECT o.*,p.status FROM `order` o JOIN payment p ON o.id = p.order_id $search_sql ORDER BY $sort $dir";
require_once '../lib/SimplePager.php';
$p = new SimplePager($sql, $params, 10, $page);
$arr = $p->result;

// ----------------------------------------------------------------------------
$_title = 'Order List';
include '../head.php';
?>
<form method="get">
    <?= html_search('search', 'placeholder = "Search..."') ?>
    <button type="submit">Search</button>
</form>

<p>
    <?= $p->count ?> of <?= $p->item_count ?> record(s) |
    Page <?= $p->page ?> of <?= $p->page_count ?>
</p>

<table class="orderList">
    <tr>

        <?= table_headers($fields, $sort, $dir, "search=$search&page=$page") ?>
        <th>More</th>
    </tr>

    <?php foreach ($arr as $s): ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->datetime ?></td>
            <td><?= $s->count ?></td>
            <td><?= $s->total ?></td>
            <td><?= $s->user_id ?></td>
            <td><?= $s->status ?></td>
            <td> <button data-get="orderdetail.php?id=<?= $s->id ?>">Detail</button></td>
        </tr>
    <?php endforeach ?>
</table>

<br>
<div class="pager">
    <?= $p->html("search=$search&sort=$sort&dir=$dir") ?>
</div>
<?php
include '../foot.php';
