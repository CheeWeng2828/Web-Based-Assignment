<?php
require '../base.php';

auth("Admin");
if (is_post()) {

    $id = req('id');
    
    $stm = $_db->prepare('SELECT photo FROM product WHERE id = ?');
    $stm->execute([$id]);
    $photo = $stm->fetchColumn();
    unlink("../product_img/$photo");

    $inv = $_db->prepare('DELETE FROM inventory WHERE product_id=?');
    $inv->execute([$id]);

    $stm = $_db->prepare('DELETE FROM product WHERE id=?');
    $stm->execute([$id]);

    temp('info', 'Deleted');
    redirect('product_maintenance.php');
}
