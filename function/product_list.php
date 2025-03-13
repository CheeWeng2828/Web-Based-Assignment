<?php
include '../base.php';

$_title = "Product";
include '../head.php';

$stm = $_db->prepare('SELECT * FROM product');
$arr = $stm->fetch();

?>

<?php
include '../foot.php';