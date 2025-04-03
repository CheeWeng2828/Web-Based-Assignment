<?php
require '../base.php';


$category = $_GET['category'] ?? '';


if ($category === 'cake') {
    $query = "SELECT * FROM product WHERE name LIKE '%cake%'";
} elseif ($category === 'bread') {
    $query = "SELECT * FROM product WHERE name NOT LIKE '%cake%'";
} elseif ($category === 'pastries') {
    $query = "SELECT * FROM product WHERE name  LIKE '%Tart%'";
} else {
    $query = "SELECT * FROM product";
}

$products = $_db->query($query)->fetchAll();

$_title = ucfirst($category) ?: 'All Products';
include '../head.php';
?>

<div class="product-grid">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <img src="/product_img/<?= $product->photo ?>" alt="<?= $product->name ?>">
        <h3><?= $product->name ?></h3>
        <p>RM <?= number_format($product->price, 2) ?></p>
    </div>
    <?php endforeach; ?>
</div>

<?php include '../foot.php'; ?>