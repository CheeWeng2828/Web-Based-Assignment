<?php
require '../base.php';
$name = req('name');
// Fetch data from database
$fields = [
    'id' => 'ID',
    'name' => "Name",
    'price' => 'Price',
    'photo'=>'Photo'
];


$arr=$_db->query('SELECT * FROM product')->fetchAll();


$stm = $_db->prepare('SELECT * FROM product WHERE name LIKE ?');
$stm->execute(["%$name%"]);
$arr= $stm->fetchAll();


$_title = "Product List";
include '../head.php';
?>

<form>
    <?= html_search('name') ?>
    <button>Search</button>
</form>
<p><?= count($arr) ?> record(s)</p>

<table class="productList">
<tr>
    <th>Id</th>
    <th>Name</th>
    <th>Price</th>
</tr>

<?php foreach ($arr as $s) :?>
<tr>
    <td><?= $s->id ?></td>
    <td><?= $s->name ?>
      <img src="<?=$s->photo ?>" class="test">
    </td>
    <td><?= $s->price ?></td>
    <td> 
        <button data-get="update.php?id=<?= $s->id ?>">Update</button>
        <button data-post="delete.php?id=<?= $s->id ?>"data-confirm="Permanently Delete?"
        >Delete</button>
    </td>
<?php endforeach ?>
</tr>
</table>

<?php
include '../foot.php';