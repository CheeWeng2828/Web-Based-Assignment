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
    extract((array)$s);
    $_SESSION['photo'] = $s->photo;
    
   

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


if(!$price){
    $_err['price'] = "Required";
}


if(!$name){
    $_err['name'] = "Required";
}
else if(strlen($name)>100){
    $_err['name'] = "Maximun 100 charater";
}
else{
    $stm = $_db->prepare('SELECT COUNT(*) FROM product WHERE name=? AND id != ?');
    $stm->execute([$name,$id]);

    if($stm->fetchColumn() > 0){
        $_err['name'] = 'Duplicated';
    }
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
        if($photo){ 
    unlink("../product_img/$photo");
        }
    $photo = save_photo($f,'../product_img');
    }
    $stm = $_db->prepare('
    UPDATE product
    SET price = ?,name = ?,photo = ?
    WHERE id = ?
');
$stm->execute([$price,$name,$photo,$id]);


    temp('info','Update Sucessful');
    redirect('/');
}
}

$_title = "Product Update";
include '../head.php';
?> 

<form method="post" class="form" enctype="multipart/form-data">
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