<?php
include '../base.php';
//-----------------------------------------------------------------------------

// (1) Sorting
$fields = [
    'id' => 'ID',
    'email' => 'email',
    'name' => "Name",
    'role' => 'Role'
];

$sort = req('sort');
key_exists($sort, $fields) || $sort = 'id';

$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';

// (2) Paging
$page = req('page', 1);

require_once '../lib/SimplePager.php';
$p = new SimplePager("SELECT * FROM user ORDER BY $sort $dir", [], 10, $page);
$arr = $p->result;


// ----------------------------------------------------------------------------
$_title = 'Member List';
include '../head.php';
?>

<p>
    <?= $p->count ?> of <?= $p->item_count ?> record(s) |
    Page <?= $p->page ?> of <?= $p->page_count ?>
</p>

<table class="memberList">
    <tr>

        <?= table_headers($fields, $sort, $dir, "page=$page") ?>
        <th colspan="2"></th>
        
    </tr>

    <?php foreach ($arr as $s): ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->email ?></td>
            <td><?= $s->name ?></td>
            <td><?= $s->role ?></td>
            <td><img src="/photo/<?=$s->photo ?>" ></td>
            <td>
                <button data-post="deleteMember.php?id=<?= $s->id ?>" data-confirm="Permanently Delete?">Delete</button>

            </td>
        </tr>
    <?php endforeach ?>
</table>

<br>
<div class="pager">
<?= $p->html("sort=$sort&dir=$dir",) ?>
</div>
<?php
include '../foot.php';
