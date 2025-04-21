<?php
require '../base.php';

if (is_post()) {
    $id = req('id');
    $unit = req('unit');
    $stock = req('stock');
    update_cart($id, $unit,$stock);
    redirect();
}

$category = $_GET['category'] ?? '';


if ($category === 'cake') {
    $query = "SELECT * FROM product WHERE name LIKE '%cake%'";
} elseif ($category === 'bread') {
    $query = "SELECT * FROM product WHERE name NOT LIKE '%cake%' AND name NOT LIKE'%Tart%'";

} elseif ($category === 'pastries') {
    $query = "SELECT * FROM product WHERE name LIKE '%Tart%'";
} else {
    $query = "SELECT * FROM product ";
}

$products = $_db->query($query)->fetchAll();

$_title = ucfirst($category) ?: 'All Products';
include '../head.php';
?>

<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <?php
        $cart = get_cart();
        $id = $product->id;
        $stock = $product->stock;
        $unit = $cart[$product->id] ?? 0;
        ?>
            
    <div class="product-card">
        <img src="/product_img/<?= $product->photo ?>" alt="<?= $product->name ?>" data-get="detail.php?id=<?= $product->id ?>">
        <h3><?= $product->name ?></h3>
        <p>RM <?= number_format($product->price, 2) ?></p>
        <p><?=$product->stock ?> pieces available</p>
        <form method="post">
        <?php if($product->stock != 0): ?>
                <?= html_hidden('id') ?>
                <?= html_hidden('stock')?>
                <?= html_select('unit', $_units, '') ?>
                <?= $unit ? '✅' : '' ?>
                <?php endif ?>
            </form>
    </div>
    <?php endforeach; ?>
</div>
<script>
    $('select').on('change', e => e.target.form.submit());
</script>
<?php include '../foot.php'; ?>