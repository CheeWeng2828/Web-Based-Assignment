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
<div class="productDetailContainer">
    <p>
        <img src="/product_img/<?= $product->photo ?>" class="productDetailIMG">
    </p>
    <div class="productDetail">
        <p class="productName"><?= $product->name ?></p>
        <p class="productName">RM<?= $product->price ?></p><br>
        <div class="productDescription">
            <p>
                <?= $product->description ?>
            </p>
        </div>
    </div>
</div>
<?php
$cart = get_cart();
$id = $product->id;
$quantity = $product->quantity;
$unit = $cart[$product->id] ?? 0;
?>
<form method="post" class="productDetailQuantity">
    <?= html_hidden('id') ?>
    Quantity: <?= html_hidden('quantity') ?>
    <?= html_select('unit', $_units, '') ?>
    <?= $unit ? '✅' : '' ?>
    <?= $product->quantity ?> Piece Available
</form>
<p>
    <button data-get="shop.php" class="backButton">Back</button>
</p>
<script>
    $('select').on('change', e => e.target.form.submit());
</script>
<?php
include '../foot.php';
