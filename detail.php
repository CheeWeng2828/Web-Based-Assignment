<?php
include 'base.php';

if (is_post()) {
    $id = req('id');
    $units = req('unit');
    update_cart($id, $units);
    redirect();
}

$id = req('id');
$stm = $_db->prepare("SELECT * FROM product WHERE id = ?");
$stm->execute([$id]);
$product = $stm->fetch();
if (!$product) redirect('index.php');

$_title = 'Detail';
include 'head.php';
?>

<p>
    <img src="/product_img/<?= $product->photo ?>" id="productDetailIMG">
</p>
<table class="product detail">
    <tr>
        <th>ID</th>
        <td><?= $product->id ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?= $product->name ?></td>
    </tr>
    <tr>
        <th>Price</th>
        <td><?= $product->price ?></td>
    </tr>
    <tr>
        <td>
            <?php
            $cart = get_cart();
            $id = $product->id;
            $unit = $cart[$product->id] ?? 0;
            ?>
            <form method="post">
                <?= html_hidden('id') ?>
                <?= html_select('unit', $_units, '') ?>
                <?= $unit ? '✅' : '' ?>
            </form>
        </td>
    </tr>
</table>
<p>
    <button data-get="index.php">List</button>
</p>

<script>
    $('select').on('change', e => e.target.form.submit());
</script>
<?php
include 'foot.php';
