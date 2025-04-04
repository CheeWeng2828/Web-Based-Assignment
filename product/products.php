<?php
require '../base.php';

if (is_post()) {
    $id = req('id');
    $unit = req('unit');
    $quantity = req('quantity');
    update_cart($id, $unit,$quantity);
    redirect();
}

$category = $_GET['category'] ?? '';


if ($category === 'cake') {
    $query = "SELECT p.*,i.quantity FROM product AS p JOIN inventory AS i ON p.id = i.product_id WHERE p.name LIKE '%cake%'";
} elseif ($category === 'bread') {
    $query = "SELECT p.*,i.quantity FROM product AS p JOIN inventory AS i ON p.id = i.product_id WHERE p.name NOT LIKE '%cake%'";
} elseif ($category === 'pastries') {
    $query = "SELECT p.*,i.quantity FROM product AS p JOIN inventory AS i ON p.id = i.product_id WHERE p.name  LIKE '%Tart%'";
} else {
    $query = "SELECT p.*,i.quantity FROM product AS p JOIN inventory AS i ON p.id = i.product_id";
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
        $quantity = $product->quantity;
        $unit = $cart[$product->id] ?? 0;
        ?>
            
    <div class="product-card">
        
        <img src="/product_img/<?= $product->photo ?>" alt="<?= $product->name ?>" data-get="detail.php?id=<?= $product->id ?>">
        <h3><?= $product->name ?></h3>
        <p>RM <?= number_format($product->price, 2) ?></p>
        <p><?=$product->quantity ?> pieces available</p>
        <form method="post">
            <label>Quantity</label>
                <?= html_hidden('id') ?>
                <?= html_hidden('quantity')?>
                <?= html_select('unit', $_units, '') ?>
                <?= $unit ? '✅' : '' ?>
            </form>
    </div>
    <?php endforeach; ?>
</div>
<script>
    $('select').on('change', e => e.target.form.submit());
</script>
<?php include '../foot.php'; ?>