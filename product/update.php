<?php
require '../base.php';

if(is_get()){
$id=req('id');

$stm = $_db->prepare('SELECT * FROM product WHERE id=?');
$stm->execute([$id]);
$s = $stm->fetch();

if(!$s){
    redirect('/');
}
$id =$s->id;
$name =$s->name;
$price =$s->price;
$photo =$s->photo;

}

if (is_post()) {
    $id         = req('id'); 
    $name       = req('name');
    $price     = req('price');
    $photo = $_SESSION['photo'];
    $f = get_file('photo');
}

$_title = "Product Update";
include '../head.php';
?> 

<form method="post" class="form">
    <label for="id">Id</label>
    <b><?= $id ?></b>
    <?= err('id') ?>

    <label for="name">Name</label>
    <?= html_text('name', 'maxlength="100"') ?>
    <?= err('name') ?>

    <label for="price">Price</label>
    <?= html_text('price', 'maxlength="5"') ?>
    <?= err('price') ?>

    <label for="photo">Photo</label>
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="/product_img/<?= $photo ?>">
    </label>
    <?= err('photo') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../foot.php';