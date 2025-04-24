<?php
include '../base.php';

auth('Admin');

$search = req('search');

$result = $_db->prepare('SELECT * FROM user WHERE name LIKE ?');
$result->execute(["%$search%"]);
$arr = $result->fetchAll();

$_title = 'Member List';
include '../head.php';
?>
<p>
    Create New Admin Account ? <a href="addAdmin.php">Click Me</a>
</p>

<form method="get">
    <?= html_search('search', 'placeholder = "Search..."') ?>
    <button type="submit">Search</button>
</form>
<p><?= count($arr) ?> record(s)</p>

<table class="memberList">
    <tr>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
        <th>Role</th>
        <th>Photo</th>
        <th>More</th>
    </tr>

    <?php foreach ($arr as $s): ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->email ?></td>
            <td><?= $s->name ?></td>
            <td><?= $s->role ?></td>
            <td><img src="/photo/<?= $s->photo ?>"></td>
            <td>
                <button data-get="memberDetail.php?id=<?= $s->id ?>">Detail</button>
                <button data-post="deleteMember.php?id=<?= $s->id ?>" data-confirm="Permanently Delete?">Delete</button>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?php
include '../foot.php';
