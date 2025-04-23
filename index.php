<?php
require 'base.php';

$_title = 'Welcome';
include 'head.php';
?>
<?php if (!$_user || $_user->role == "Member") : ?>
    <h2>Bakery Menu</h2>

    <div class="category-cards">

        <a href="../product/products.php" class="card">
            <img src="/image/all.jpg" alt="All Products">
            <span>All Products</span>
        </a>
        <div class="category-cards">
            <a href="../product/products.php?category=cake" class="card">
                <img src="/image/cake.jpg" alt="Delicious Cakes">
                <span>Cakes</span>
            </a>
            <a href="../product/products.php?category=bread" class="card">
                <img src="/image/breadbackground.jpg" alt="Fresh Bread">
                <span>Bread</span>
            </a>

            <a href="../product/products.php?category=pastries" class="card">
                <img src="/image/tartt.png" alt="Pastries">
                <span>Pastries</span>
            </a>
        </div>
    <?php else: ?>
        <h2>This is Admin Page</h2>
    <?php endif ?>
<?php
include 'foot.php';
