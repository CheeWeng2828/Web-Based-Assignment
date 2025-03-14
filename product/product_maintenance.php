<?php
require '../base.php';
// Fetch data from database
$fields = [
    'id' => 'ID',
    'name' => "Name",
    'price' => 'Price'
    

];

$arr=$_db->query('SELECT * FROM product')->fetchAll();

$_title = "Product List";
include '../head.php';
?>
<table class="productList">
<tr>
    <th>Id</th>
    <th>Name</th>
    <th>Price</th>
</tr>

<?php foreach ($arr as $s) :?>
<tr>
    <td><?= $s->id ?></td>
    <td><?= $s->name ?></td>
    <td><?= $s->price ?></td>
    <td> 
        <button data-get="update.php?id=<?= $s->id ?>">Update</button>
        <button data-post="delete.php?id=<?= $s->id ?>">Delete</button>
    </td>
<?php endforeach ?>
</tr>
</table>

<?php
include '../foot.php';