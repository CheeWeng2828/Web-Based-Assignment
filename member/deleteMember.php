<?php
require '../base.php';

if (is_post()) {

    $user_id = req('id');
    $photo = get_file('photo');

    if ($photo) {
        unlink("../photo/$photo");
    }

    $_db->beginTransaction();

    $order = $_db->prepare("SELECT id FROM `order` WHERE user_id = ?");
    $order->execute([$user_id]);
    $orders = $order->fetchAll();

    foreach ($orders as $arr) {
        $orderID = $arr->id;
        $stm1 = $_db->prepare("DELETE FROM item WHERE order_id = ?");
        $stm1->execute([$orderID]);

        $stm0 = $_db->prepare("DELETE FROM payment WHERE order_id = ?");
        $stm0->execute([$orderID]);
    }

    $stm2 = $_db->prepare("DELETE FROM `order` WHERE user_id=?");
    $stm2->execute([$user_id]);

    $stm3 = $_db->prepare("DELETE FROM token WHERE user_id = ?");
    $stm3->execute([$user_id]);

    $stm4 = $_db->prepare('DELETE FROM user_payment WHERE id = ?');
    $stm4->execute([$user_id]);

    $stm5 = $_db->prepare('DELETE FROM user WHERE id=?');
    $stm5->execute([$user_id]);

    $_db->commit();

    temp('info', 'Deleted');
    redirect('memberList.php');
}
