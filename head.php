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
    <?php if($_user):?>
        <div>
            <?=$_user->name ?><br>
            <?=$_user->role?>
        </div>
        <img src="/photo/<?= $_user->photo ?>">
        <?php endif?>
    </header>
    <nav>
            <a href="/">Home</a>
            <?php if(!$_user):?>
            <a href="/function/login.php">Login</a>
            <a href="/function/register.php">Register</a>
            <?php endif ?>
            <?php if($_user?->role == "Admin"): ?>
            <a href="/function/user_list.php">User List</a>
            <?php endif ?>
            <div></div>
            <?php if($_user):?>
            <a href="/function/logout.php">Logout</a>
            <a href="/function/profile.php">Profile</a>
            <a href="/function/password.php">Password</a>
            <?php endif ?>
    </nav>
    
<main>
    <h1><?=$_title ?? 'Untitled'?></h1>