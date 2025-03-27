<?php
include '../base.php';

if (is_post()) {
    $id = req('id');
    $unit = req('unit');
    update_cart($id, $unit);
    redirect();
}

$stm = $_db->query("SELECT * FROM product");

$_title = 'Product';
include '../head.php';
?>

<div class="productContainer">
    <?php foreach ($stm as $product): ?>
        <?php
        $cart = get_cart();
        $id = $product->id;
        $unit = $cart[$product->id] ?? 0;
        ?>
        <div class="product">
            <form method="post">
                <?= $unit ? '✅' : '' ?>
                <?= html_hidden('id') ?>
                <?= html_select('unit', $_units, '') ?>
            </form>
            <img src="../product_img/<?= $product->photo ?>"
                data-get="detail.php?id=<?= $product->id ?>" class="productImg">
            <div class="productDetail">
                <p><?= $product->name ?><br>RM<?= $product->price ?>
            </div>
        </div>
    <?php endforeach ?>

</div>

<script>
    $('select').on('change', e => e.target.form.submit());
</script>

<?php
include '../foot.php';