<?php
require '../base.php';

if (is_post()) {

    $user_id = req('id');

    $query = $_db->prepare('SELECT active FROM user WHERE id = ?');
    $query->execute([$user_id]);
    $status = $query->fetch();


    if ($status->active == "Yes") {
        $stm = $_db->prepare('UPDATE user SET active = "No" WHERE id = ? ');
        $stm->execute([$user_id]);
    }

    if ($status->active == "No") {
        $stm = $_db->prepare('UPDATE user SET active = "Yes" WHERE id = ? ');
        $stm->execute([$user_id]);
    }

    temp('info', 'Diactive Successful');
    redirect('memberList.php');
}
