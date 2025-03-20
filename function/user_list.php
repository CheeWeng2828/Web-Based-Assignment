<?php


/////////////////////////////////////////////////////
//          Dont use this function first

//  <a href="/function/user_list.php">User List</a>
////////////////////////////////////////////////////


require '../base.php';
// Fetch data from database
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

$page = req('page', 1);

require_once '../lib/SimplePager.php';
$stm = new SimplePager("SELECT * FROM user ORDER BY $sort $dir", [], 10, $page);
$arr = $stm->result;

include '../head.php';
$_title = "User List";
?>
<table class="userList">
    <tr>
        <?= html_header($fields, $sort, $dir, "page=$page") ?>
    </tr>

    <?php foreach ($arr as $s) : ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->email ?></td>
            <td><?= $s->name ?></td>
            <td><?= $s->role ?></td>
        <?php endforeach ?>
        </tr>
</table>
<?= $stm->html("sort=$sort&dir=$dir") ?>
<?php
include '../foot.php';
