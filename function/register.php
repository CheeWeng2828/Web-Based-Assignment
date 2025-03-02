<?php 
require '../base.php';
$_title = 'Register';
    if (is_post()){
        $name = req('name');

        if($name == ' '){
            $_err['name'] = 'Required';
        }

        if(!$_err){
            temp('info','Login Successful');
            redirect('/');
        }
    }
include '../head.php'

?>
    <form method="post" class="register" autocomplete="off">
            <label for="name"><strong>Name:</strong></label><br>
            <?= html_text('name','maxlength="100"') ?>
            <?= err('name') ?>
            

            <section>
                <button>Submit</button>
            </section>
            
    </form>


<?php
include '../foot.php';