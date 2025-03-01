<?php 
require '../base.php';
    if (is_post()){
        $name = req('name');

        if($uname == ' '){
            $_err[$name] = 'Required';
        }

        if(!$_err){
            redirect('/');
        }
    }
include '../head.php'

?>
    <div class="login">
    <form method="post" autocomplete="off">
            <label for="name"><strong>Username:</strong></label><br>
            <?= html_text('name','maxlength="100"') ?>
            <?= err('name') ?>
            
            <label for="psword"><strong>Password:</strong></label><br>
            <input type="password" name="psword" id="psword" placeholder="Password!"><br><br>
            <section>
                <button>Submit</button>
            </section>
            <input type="submit" value="Login">
            <button type="reset">Reset</button>
            
    </form>
    </div>

<?php
include '../foot.php';