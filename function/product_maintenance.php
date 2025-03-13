<?php
require '../base.php';
// Fetch data from database
$fields = [
    'id' => 'ID',
    'email' => 'email',
    'name' => "Name",
    'role' => 'Role'

];

$arr=$_db->query('SELECT * FROM user')->fetchAll();


include '../head.php';
$_title = "Product List";
?>
<table class="productList">
<tr>
    <th>Id</th>
    <th>Email</th>
    <th>Name</th>
    <th>Role</th>
</tr>

<?php foreach ($arr as $s) :?>
<tr>
    <td><?= $s->id ?></td>
    <td><?= $s->email ?></td>
    <td><?= $s->name ?></td>
    <td><?= $s->role ?></td>
<?php endforeach ?>
</tr>
</table>

<?php
include '../foot.php';