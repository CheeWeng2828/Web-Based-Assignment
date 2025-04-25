<?php
include '../base.php';

auth("Member");
/// Sorting Field
$fields = [
    'o.id' => 'ID',
    'o.datetime' => 'Date Time',
    'o.count' => "Quantity",
    'o.total' => 'Total Amount(RM)',
    'p.status' => 'Order Status'
];

// Sorting Field
$sort = req('sort');
key_exists($sort, $fields) || $sort = 'o.id';


// Sorting Direction
$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';

// (2) Paging
$page = req('page', 1);


$search      = req('search');
$params      = [$_user->id];
if ($search) {
    // wrap the ORs in parens to keep your logic clear
    $search_sql = " AND (o.id     LIKE ? OR 
                         p.status LIKE ?) ";
    $params[]   = "%{$search}";
    $params[]   = "%{$search}";
} else {
    $search_sql = "";
}

$sql = "SELECT o.*, p.status
        FROM `order` o 
        JOIN payment p ON o.id = p.order_id
        WHERE o.user_id = ? 
        {$search_sql}
        ORDER BY {$sort} {$dir}";

require_once '../lib/SimplePager.php';
$p = new SimplePager($sql, $params, 10, $page);
$arr = $p->result;


$_title = 'Order History';
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
    <?php foreach ($arr as $h): ?>
        <tr>
            <td><?= $h->id ?></td>
            <td><?= $h->datetime ?></td>
            <td><?= $h->count ?></td>
            <td><?= $h->total ?></td>
            <td><?= $h->status ?></td>
            <td> <button data-get="orderdetail.php?id=<?= $h->id ?>">Detail</button></td>
        </tr>
    <?php endforeach ?>
</table>

<br>
<div class="pager">
    <?= $p->html("search=$search&sort=$sort&dir=$dir") ?>
</div>
<?php
include '../foot.php';
