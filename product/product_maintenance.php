<?php
require '../base.php';
$name = req('name');

auth("Admin");

$stm = $_db->prepare('SELECT *
                      FROM product
                      WHERE name LIKE ?');
$stm->execute(["%$name%"]);
$arr = $stm->fetchAll();

$_title = "Product List";
include '../head.php';
?>

<form>
    <p><?= count($arr) ?> record(s)</p>
    <?= html_search('name') ?>
    <button>Search</button>
    <p>Any New Product? <button data-get="insert_product.php">Insert Product</button> </p>
</form>



<table class="productList">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th colspan="2">Action</th>
    </tr>

    <?php foreach ($arr as $s) : ?>
        <tr>
            <td><?= $s->id ?></td>
            <td><?= $s->name ?></td>
            <td><?= $s->price ?></td>
            <td><?= $s->stock ?></td>
            <td>
                <button data-get="update.php?id=<?= $s->id ?>">Update</button>
            </td>
            <td>
                <button data-post="delete.php?id=<?= $s->id ?>" data-confirm="Permanently Delete?">Delete</button>
                <img src="/product_img/<?= $s->photo ?>" class="popup">
            </td>
        <?php endforeach ?>
        </tr>
</table>

<?php
include '../foot.php';
