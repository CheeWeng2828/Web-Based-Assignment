<?php
include '../base.php';


if (is_post()) {
    $email = req('email');

    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_exist($email, 'user', 'email')) {
        $_err['email'] = 'Not exists';
    }

    if (!$_err) {

        $stm = $_db->prepare('SELECT * FROM user WHERE email = ?');
        $stm->execute([$email]);
        $u = $stm->fetch();

        $id = sha1(uniqid() . rand());

        $stm = $_db->prepare('
            DELETE FROM token WHERE user_id=?;

            INSERT INTO token(id,expire,user_id)
            VALUES (?,ADDTIME(NOW(),"00:05"),?);
        ');
        $stm->execute([$u->id,$id,$u->id]);

        $url = base("user/token.php?id=$id");

        $m = get_mail();
        $m->addAddress($u->email,$u->name);
        $m->addEmbeddedImage("../photo/$u->photo",'photo');
        $m->isHTML(true);
        $m->Subject = 'Reset Password';
        $m->Body = "
            <img src='cid:photo'
                 style='width: 200px; height: 200px;
                        border: 1px solid #333'>
            <p>Dear $u->name,<p>
            <h1 style='color: red'>Reset Password</h1>
            <p>
                Please click <a href='$url'>here</a>
                to reset your password.
            </p>
            <p>From, 🍞 Admin</p>
        ";
        $m->send();

        temp('info', 'Email sent');
        redirect('/');
    }
}



$_title = 'User | Reset Password';
include '../head.php';
?>

<form method="post" class="resetPass">
    <label for="email">Email</label>
    <?= html_text('email', 'maxlength="100"') ?>
    <?= err('email') ?>

    <section>
        <button class="resetSub">Submit</button>
        <button type="reset" class="rtReset">Reset</button>
    </section>
</form>

<?php
include '../foot.php';