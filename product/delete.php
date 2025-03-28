<?php
require '../base.php';

if (is_post()) {

    $id = req('id');
    
    $stm = $_db->prepare('SELECT photo FROM product WHERE id = ?');
    $stm->execute([$id]);
    $photo = $stm->fetchColumn();
    unlink("../product_img/$photo");

    $stm = $_db->prepare('DELETE FROM product WHERE id=?');
    $stm->execute([$id]);

    temp('info', 'Deleted');
    redirect('product_maintenance.php');
}
