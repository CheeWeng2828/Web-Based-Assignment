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
<<<<<<< HEAD
            <section>
                <button>Submit</button>
            </section>
=======
            <input type="submit" value="Login">
            <button type="reset">Reset</button>
            
>>>>>>> 98ddc41387c5a21df98b90590c0ca69c30700ccc
    </form>
    </div>

<?php
include '../foot.php';