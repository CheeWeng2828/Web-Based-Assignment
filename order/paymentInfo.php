<?php
include '../base.php';
auth("Member");

$userInfo = $_db->prepare('SELECT * FROM user_payment WHERE id = ?');
$userInfo->execute([$_user->id]);
$u = $userInfo->fetchAll();

$_title = 'Payment Info';
include '../head.php';
?>



<?php
include '../foot.php';