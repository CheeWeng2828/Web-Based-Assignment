<?php
require '../base.php';

$category = req('category');

if ($category === 'cake') {
    $query = "SELECT * FROM product WHERE name LIKE '%cake%' AND active = 'Yes'";
    $products = $_db->query($query)->fetchAll();
} 

elseif ($category === 'bread') {
    $query = "SELECT * FROM product WHERE name NOT LIKE '%cake%' AND name NOT LIKE'%Tart%' AND active = 'Yes'";
    $products = $_db->query($query)->fetchAll();
} 

elseif ($category === 'pastries') {
    $query = "SELECT * FROM product WHERE name LIKE '%Tart%' AND active = 'Yes'";
    $products = $_db->query($query)->fetchAll();
} 
else {
    $query = "SELECT * FROM product WHERE active = 'Yes'";
    $products = $_db->query($query)->fetchAll();
}


$_title = ucfirst($category) ?: 'All Products';
include '../head.php';
?>

<form method="get">
    Category : <?= html_select('category',$categories,'All Product')?>
</form>

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
            <p><?= $product->stock ?> pieces available</p>
        </div>
    <?php endforeach; ?>
</div>
<script>
    $('select').on('change', e => e.target.form.submit());
</script>
<?php include '../foot.php'; ?>