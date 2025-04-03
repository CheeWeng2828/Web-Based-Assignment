<?php
include '../base.php';

if (is_post()) {
    $id = req('id');
    $unit = req('unit');
    $quantity = req('quantity');
    update_cart($id, $unit,$quantity);
    redirect();
}

$stm = $_db->query("SELECT p.*,i.quantity FROM product AS p JOIN inventory AS i ON p.id = i.product_id");

$_title = 'Product';
include '../head.php';
?>

<div class="productContainer">
    <?php foreach ($stm as $product): ?>
        <?php
        $cart = get_cart();
        $id = $product->id;
        $quantity = $product->quantity;
        $unit = $cart[$product->id] ?? 0;
        ?>
        <div class="product">
            <form method="post">
                <?= $unit ? '✅' : '' ?>
                <?= html_hidden('id') ?>
                <?= html_hidden('quantity')?>
                <?= html_select('unit', $_units, '') ?>
            </form>
            <img src="../product_img/<?= $product->photo ?>"
                data-get="detail.php?id=<?= $product->id ?>" class="productImg">
            <div class="productDetail">
                <p><?= $product->name ?><br>RM<?= $product->price ?><br><?= $product->quantity ?> pieces available</p>
            </div>
        </div>
    <?php endforeach ?>

</div>

<script>
    $('select').on('change', e => e.target.form.submit());
</script>

<?php
include '../foot.php';