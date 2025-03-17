<?php

require 'base.php';

$stm = $_db->query("SELECT * FROM product");

$_title = 'Index';
include 'head.php';
?>

<div class="productContainer">
<?php foreach($stm as $product): ?>
    <div class="product">
    <img src="../product_img/<?=$product->photo ?>" class="productImg">
    <div class="productDetail"><p ><?= $product->name ?><br>RM<?= $product->price ?></div>
    </div>
<?php endforeach ?>
</div>

<?php
include 'foot.php';