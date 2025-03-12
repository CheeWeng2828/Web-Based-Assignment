<?php
include '../base.php';

auth();

if(is_get()){
    $stm = $_db->prepare('SELECT * FROM user WHERE id = ?');
    $stm->execute([$_user->id]);
    $u = $stm->fetch();

    if(!$u){
        redirect('/');
    }
    extract((array)$u);
    $_SESSION['photo'] = $u->photo;

}
if(is_post()){
    $email = req('email');
    $name = req('name');
    $photo = $_SESSION['photo'];
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
        else{
            $stm = $_db->prepare('SELECT COUNT(*) FROM user WHERE email=? AND id != ?');
            $stm->execute([$_user->email,$_user->id]);

            if($stm->fetchColumn() > 0){
                $_err['email'] = 'Duplicated';
            }
        }

        if(!$name){
            $_err['name'] = "Required";
        }
        else if(strlen($name)>100){
            $_err['name'] = "Maximun 100 charater";
        }

        if($f){
            if($f->size > 1*1024*1024){
            $_err['photo'] = "Maximun Size is 1MB";
        }
            else if(!str_starts_with($f->type,'image/')){
            $_err['photo'] = 'Must be image';
        }
    }

        if(!$_err){
            if($f){
            unlink("../photo/$photo");
            save_photo($f,'../photo');
            }
            $stm = $_db->prepare('
            UPDATE user
            SET email = ?,name = ?,photo = ?
            WHERE id = ?
        ');
        $stm->execute([$email,$name,$photo,$_user->id]);

            $_user->email = $email;
            $_user->name = $name;
            $_user->photo = $photo;

            temp('info','Update Sucessful');
            redirect('/');
        }
    }
$_title = 'Profile';
include '../head.php'
?>
<form method="post" class="register" enctype="multipart/form-data">
    <label for="email">Email</label>
    <?=html_text('email','maxlength="100"')?>
    <?= err('email') ?>

    <label for="name">Name</label>
    <?=html_text('name','maxlength="100"')?>
    <?= err('name') ?>

    <label for="photo">Photo</label>
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="/photos/<?= $photo ?>">
    </label>
    <?= err('photo') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>
<?php
include '../foot.php';