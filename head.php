<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Untitled' ?></title>
    <link rel="icon" href="/image/icon.jpg">
    <link rel="stylesheet" href="/css/bakery.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="/js/app.js"></script>
</head>

<body>
<header>
         <a href="/">
             <img src="/image/icon.jpg" alt="logo" class="logo">
             <h1 class="name">SEM 3's Bakery</h1>
         </a>
         <div></div>
         <?php if ($_user): ?>
 
             <div class="user">
                 <img src="/photo/<?= $_user->photo ?>">
                 <?= $_user->name ?>
             </div>
 
         <?php endif ?>
     </header>
    <div id="info"><?= temp('info') ?></div>
    <nav class="navigation">
        <a href="/">Home</a>
        <?php if (!$_user || $_user?->role == "Member"): ?>
        <a href="/order/shopping_cart.php">
            Shopping Cart
            <?php
            $cart = get_cart();
            $count = array_sum($cart);
            if ($count) echo "($count)";
            ?>
        </a>
        <?php endif ?>

        <?php if ($_user?->role == "Admin"): ?>

            <?= remove_cart() ?>
            <a href="/product/product_maintenance.php">Product</a>
            <a href="/member/memberList.php">Member List</a>
            <a href="/order/order_list.php">Order List</a>
            <a href = "/member/addAdmin.php">New Admin</a>

        <?php endif ?>

        <div></div>

        

        <?php if (!$_user): ?>

            <a href="/user/login.php">Login</a>
            <a href="/user/register.php">Register</a>
            <a href="/user/reset.php">Forget Password</a>

        <?php endif ?>

        <?php if ($_user?->role == "Member"): ?>

            <a href="/order/history.php">History</a>

        <?php endif ?>

        <?php if ($_user): ?>
            <a href="/order/addresswitpay.php">Payment</a>
            <a href="/order/paymentInfo.php">Info</a>
            <a href="/user/profile.php">Profile</a>
            <a href="/user/password.php">Password</a>
            <a href="/user/logout.php">Logout</a>


        <?php endif ?>

    </nav>

    <main>
        <h1><?= $_title ?? 'Untitled' ?></h1>

