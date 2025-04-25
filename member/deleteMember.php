<?php
require '../base.php';

if (is_post()) {

    $user_id = req('id');

    $stm = $_db->prepare('UPDATE user SET active = "No" WHERE id = ? ');
    $stm->execute([$user_id]);

    temp('info', 'Deleted');
    redirect('memberList.php');
}
