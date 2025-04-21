<?php
require '../base.php';

auth("Admin");
if (is_post()) {

    $id = req('id');
    
    // Get the Photo name and delete the photo at file
    $stm = $_db->prepare('SELECT photo FROM product WHERE id = ?');
    $stm->execute([$id]);
    $photo = $stm->fetchColumn();
    unlink("../product_img/$photo");

    $stm = $_db->prepare('DELETE FROM product WHERE id=?');
    $stm->execute([$id]);

    temp('info', 'Deleted');
    redirect('product_maintenance.php');
}
