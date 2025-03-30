<?php
include '../base.php';


/*我还没弄好的*/

$inv = $_db->query('SELECT * FROM inventory AS i,order AS o
                    WHERE i.order_id = o.id');

$_title = "Inventory";
include '../head.php';
?>

<?php
include '../foot.php';