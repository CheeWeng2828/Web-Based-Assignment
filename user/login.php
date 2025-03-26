<?php
require '../base.php';

if (is_post()) {
    $email = req('email');
    $password = req('password');

    if ($email == '') {
        $_err['email'] = 'Required';
    }
    if (!is_email($email)) {
        $_err['email'] = 'Invalid Email';
    }

    if ($password == '') {
        $_err['password'] = 'Required';
    }

    if (!$_err) {
        $stm = $_db->prepare('SELECT * FROM user WHERE email = ? AND password = SHA1(?)');
        $stm->execute([$email, $password]);
        $u = $stm->fetch();

        if ($u) {
            temp('info', 'Login Successful');
            login($u);
        } else {
            $_err['password'] = "Not Matched";
        }
    }
}

$_title = 'Login';
include '../head.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="app.css"> <link rel="stylesheet" href="app.css">
</head>
<body>

<div class="neumorphic-card">
    <h1>Login</h1>
    <form method="post">
        <input type="text" name="email" class="neumorphic-input" placeholder="Enter Email">
        <?= err('email') ?>

        <input type="password" name="password" class="neumorphic-input" placeholder="Enter Password">
        <?= err('password') ?>

        <button type="submit" class="neumorphic-button">Login</button>
        <button type="reset" class="neumorphic-button">Reset</button>
    </form>
</div>

</body>
</html>


<?php
include '../foot.php';
