<?php
require '../base.php';

if (is_post()) {

    $user_id = req('id');
    $photo = get_file('photo');

    if ($photo) {
        unlink("../photo/$photo");
    }

    $order = $_db->prepare('SELECT id FROM `order` WHERE user_id = ?');
    $order->execute([$user_id]);
    $order_id = $order->fetchAll();


    $_db->beginTransaction();

    $token = $_db->prepare("DELETE FROM `token` WHERE user_id = ?");
    $token->execute([$user_id]);

    $userPayment = $_db->prepare('DELETE FROM `user_payment` WHERE user_id = ?');
    $userPayment->execute([$user_id]);

    foreach($order_id as $id){
    $payment = $_db->prepare('DELETE FROM `payment` WHERE order_id = ?');
    $payment->execute([$id->id]);

    $item = $_db->prepare('DELETE FROM `item` WHERE order_id = ?');
    $item->execute([$id->id]);
    }

    $order = $_db->prepare('DELETE FROM `order` WHERE user_id = ?');
    $order->execute([$user_id]);

    $user = $_db->prepare('DELETE FROM `user` WHERE id = ?');
    $user->execute([$user_id]);

    $_db->commit();

    temp('info', 'Deleted');
    redirect('memberList.php');
}
