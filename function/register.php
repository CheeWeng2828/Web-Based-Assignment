<?php
require '../base.php';

if(is_get()){
    $email = req('email');
    $name = req('name');
    $password = req('password');
    $confirm = req('confirm');
    $f = get_file('photo');

        if(!$email){
            $_err['email'] = "Required";
        }
        else if(!is_email($email)){
            $_err['email'] = "Invalid email";
        }
        else if(strlen($email)>100){
            $_err['email'] = "Maximun 100 charater";
        }
        else if (!is_unique($email, 'user', 'email')) {
            $_err['email'] = 'Duplicated';
        }

        if(!$name){
            $_err['name'] = "Required";
        }
        else if(strlen($name)>100){
            $_err['name'] = "Maximun 100 charater";
        }

        if(!$password){
            $_err['password'] = "Required";
        }
        else if (strlen($password) < 5 || strlen($password) > 100) {
            $_err['password'] = 'Between 5-100 characters';
        }

        if(!$confirm){
            $_err['confirm'] = "Required";
        }
        else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
            $_err['confirm'] = 'Between 5-100 characters';
        }
        else if($confirm != $password){
            $_err['confirm'] = "Not Match";
        }
}

$_title = 'Register';
include '../head.php';

?>
<form method="post" class="register">
    <label for="email">Email</label>
    <?=html_text('email','maxlength="100"')?>
    <?= err('email') ?>

    <label for="name">Name</label>
    <?=html_text('name','maxlength="100"')?>
    <?= err('name') ?>

    <label for="password">Password</label>
    <?=html_password('password','maxlength="100"')?>
    <?= err('password') ?>

    <label for="confirm">Confirm</label>
    <?=html_password('confirm','maxlength="100"')?>
    <?= err('confirm') ?>

    <label for="upload">Upload Photo</label>
    <label class="upload">
    <?= html_file("photo","image/*")?>
    <img src="../image/placeholder.jpg">
    </label>
    <?= err("photo") ?>

</form>


<?php
include '../foot.php';