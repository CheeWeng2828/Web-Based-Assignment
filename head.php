<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Untitled' ?></title>
    <link rel="icon" href="/image/icon.jpg">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="/js/app.js"></script>
</head>

<body>
    <div id="info"><?= temp('info') ?></div>
    <header>
        <a href="/"><img class="logo" src="/image/icon.jpg" alt="Logo"></a>
        <h1 style="text-align: left;">XX bakery</h1>
        <?php if ($_user): ?>
            <div>
                <?= $_user->name ?><br>
                <?= $_user->role ?>
            </div>
            <img src="/photo/<?= $_user->photo ?>">
        <?php endif ?>
    </header>
    <nav>
        <a href="/">Home</a>
        <?php if (!$_user): ?>
            <a href="/user/login.php">Login</a>
            <a href="/user/register.php">Register</a>
        <?php endif ?>
        <?php if ($_user?->role == "Admin"): ?>
            <a href="/product/product_maintenance.php">Product List</a>
            <a href="/product/insert_product.php">Insert Product</a>
        <?php endif ?>
        <div></div>
        <?php if ($_user): ?>
            <a href="/function/shopping _cart.php">
                Shopping Cart
                <?php
                $cart = get_cart();
                $count = array_sum($cart);
                if ($count) echo "($count)";
                ?>
            </a>
            <a href="/user/logout.php">Logout</a>
            <a href="/user/profile.php">Profile</a>
            <a href="/user/password.php">Password</a>
        <?php endif ?>
    </nav>

    <main>
        <h1><?= $_title ?? 'Untitled' ?></h1>