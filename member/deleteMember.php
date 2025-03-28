<?php
require '../base.php';

if (is_post()) {

    $id = req('id');
    $photo = get_file('photo');

    if($photo){
        unlink("../photo/$photo");
    }

    $stm = $_db->prepare('DELETE FROM user WHERE id=?');
    $stm->execute([$id]);

    temp('info', 'Deleted');
    redirect('memberList.php');
}
