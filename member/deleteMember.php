auth("Admin");
if (is_post()) {

    $id = req('id');
    
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


    
