<?php

date_default_timezone_set('Asia/Kuala_Lumpur'); 
session_start();

function is_get(){
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function is_post(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function post($key,$value = null){
    $value = $_POST[$key] ?? $value;
    return is_array($value) ? array_map('trim',$value) : trim($value); 
}

function get($key,$value = null){
    $value = $_GET[$key] ?? $value;
    return is_array($value) ? array_map('trim',$value) : trim($value);
}
<<<<<<< HEAD

function req($key,$value = null){
    $value = $_REQUEST[$key];
    return is_array($value) ? array_map("trim",$value) : trim($value);
}

function redirect($url = null){
    $url ??= $_SERVER['REQUEST_URI'];
    header("Location:$url");
    exit();
}

function temp($key,$value = null)
{
    if($value !== null){
        $_SESSION["temp_$key"] == $value;
    }


    else{
        $value = $_SESSION["temp_$key"];
        unset($_SESSION["temp_$key"]);
        return $value;
    }
}
//===================================================================================
// HTML
//===================================================================================

function encode($value){
    return htmlentities($value);
}


function html_text($key,$attr = ''){
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='text' id='$key' name='$key' value='$value' $attr>";
}



//===================================================================================
// Error Handling
//===================================================================================
$_err = [];

function err($key){
    global $_err;
    if($err[$key] ?? false){
        echo "<span class ='err'>$_err[$key]</span>";
    }
    else{
        echo '<span> </span>';
    }
}

//===================================================================================
//DATABASE
//===================================================================================
$_db = new PDO('mysql:dbname=db7','root','',[
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);


=======
>>>>>>> 98ddc41387c5a21df98b90590c0ca69c30700ccc
