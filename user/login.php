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

        if ($u && $u->active == "Yes") {
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
<div class="login-container">
    <div class="login-page">
        <form method="post" class="login">
            <label for="email">Email</label>
            <div class="login-input">
                <?= html_text('email', 'maxlength:"100"') ?>
                <?= err('email') ?>
            </div>
            

            <label for="password">Password</label>
            <div class="login-input">
                <?= html_password('password', 'maxlength="100"') ?>
                <?= err('password') ?>
            </div>
            <section>
                <button class="login-button">Login</button>
                <button class="login-button" type="reset">Reset</button>
            </section>
            <p>Forget Password ? <a href="/user/reset.php">Click Me</a> !!!</p>
        </form>
    </div>
</div>


<?php
include '../foot.php';
