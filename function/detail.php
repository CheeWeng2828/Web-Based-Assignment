<?php
include '../base.php';

if (is_post()) {
    $id = req('id');
    $units = req('unit');
    $quantity = req('quantity');
    update_cart($id, $units, $quantity);
    redirect();
}

$id = req('id');
$stm = $_db->prepare("SELECT p.*,i.quantity FROM product AS p JOIN inventory AS i ON i.product_id = p.id WHERE p.id = ?");
$stm->execute([$id]);
$product = $stm->fetch();
if (!$product) redirect('index.php');

$_title = 'Detail';
include '../head.php';
?>

<p>
    <img src="/product_img/<?= $product->photo ?>" class="productDetailIMG">
</p>
<table class="productDetail">
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
        <th>Quantity</th>
        <td><?= $product->quantity ?>
    </tr>
    <tr>
        <td>
            <?php
            $cart = get_cart();
            $id = $product->id;
            $quantity = $product->quantity;
            $unit = $cart[$product->id] ?? 0;
            ?>
            <form method="post">
                <?= html_hidden('id') ?>
                <?= html_hidden('quantity') ?>
                <?= html_select('unit', $_units, '') ?>
                <?= $unit ? '✅' : '' ?>
            </form>
        </td>
    </tr>
</table>
<p>
    <button data-get="shop.php">Back</button>
</p>

<script>
    $('select').on('change', e => e.target.form.submit());
</script>
<?php
include '../foot.php';
