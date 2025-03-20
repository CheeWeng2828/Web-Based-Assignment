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
        $stm = $_db->prepare('SELECT * FROM user
                          WHERE email = ? AND password = SHA1(?)');
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
<form method="post" class="login">
    <label for="email">Email</label>
    <?= html_text('email', 'maxlength:"100"') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', 'maxlength="100"') ?>
    <?= err('password') ?>

    <section>
        <button>Login</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../foot.php';
