<?php
require '../base.php';

if (is_post()) {

    $user_id = req('id');
    $photo = get_file('photo');

    if ($photo) {
        unlink("../photo/$photo");
    }

    $_db->beginTransaction();

    $token = $_db->prepare("DELETE FROM `token` WHERE user_id = ?");
    $token->execute([$user_id]);

    $userPayment = $_db->prepare('DELETE FROM `user_payment` WHERE user_id = ?');
    $userPayment->execute([$user_id]);

    $payment = $_db->prepare('DELETE p FROM `payment` AS p INNER JOIN `order` AS o ON p.order_id = o.id WHERE o.user_id = ?');
    $payment->execute([$user_id]);

    $item = $_db->prepare('DELETE i FROM `item` AS i INNER JOIN `order` AS o ON i.order_id = o.id WHERE o.user_id = ?');
    $item->execute([$user_id]);

    $order = $_db->prepare('DELETE FROM `order` WHERE user_id = ?');
    $order->execute([$user_id]);

    $user = $_db->prepare('DELETE FROM `user` WHERE id = ?');
    $user->execute([$user_id]);

    $_db->commit();

    temp('info', 'Deleted');
    redirect('memberList.php');
}
