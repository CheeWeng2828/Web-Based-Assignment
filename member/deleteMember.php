auth("Admin");
if (is_post()) {

    $id = req('id');
    
    $stm = $_db->prepare('UPDATE product SET active = "No" WHERE id = ? ');
    $stm->execute([$id]);

    temp('info', 'Diactive');
    redirect('product_maintenance.php');
}