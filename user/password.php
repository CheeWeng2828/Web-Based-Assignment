<?php
include '../base.php';

$_title = 'Reset Password';
include '../head.php';
auth();
if (is_post()) {

    $password       = req('password');
    $new_password   = req('new_password');
    $confirm        = req('confirm');

    if ($password == '') {
        $_err['password'] = 'Require';
    } else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5 - 100 charaters';
    } else {
        $stm = $_db->prepare('
                SELECT COUNT(*)FROM user
                WHERE password = SHA1(?) AND id = ?
                ');
        $stm->execute([$password, $_user->id]);

        if ($stm->fetchColumn() == 0) {
            $_err['password'] = 'Not Matched';
        }
    }
    if ($new_password == '') {
        $_err['new_password'] = 'Require';
    } else if (strlen($new_password) < 5 || strlen($new_password) > 100) {
        $_err['new_password'] = 'Between 5 - 100 charaters';
    }
    if ($confirm == '') {
        $_err['confirm'] = 'Require';
    } else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5 - 100 charaters';
    } else if ($new_password != $confirm) {
        $_err['$confirm'] = 'Not Matched';
    }

    if (!$_err) {
        $stm = $_db->prepare('
                UPDATE user
                SET password = SHA1(?)
                WHERE id = ?
                ');
        $stm->execute([$new_password, $_user->id]);

        temp('Info', 'Update Sucessful');
        redirect('/');
    }
}

?>
<form method="post" class="reset_password" enctype="multipart/form-data">

    <label for="password">Password:</label><br>
    <?= html_password('password', 'maxlength = "100"') ?>
    <? err('password') ?><br><br>

    <label for="new_password">New Password:</label><br>
    <?= html_password('new_password', 'maxlength = "100"') ?>
    <? err('new_password') ?><br><br>

    <label for="confirm">Confirm:</label><br>
    <?= html_password('confirm', 'maxlength = "100"') ?>
    <? err('confirm') ?><br><br>
    <section>
        <button class="resetSub">Submit</button>
        <button type="reset" class="rtReset">Reset</button>
    </section>
</form>
<?php
include '../foot.php';