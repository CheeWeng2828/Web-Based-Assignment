<?php

date_default_timezone_set('Asia/Kuala_Lumpur'); 
session_start();
//===================================================================================
// PHP function
//===================================================================================
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

function req($key,$value = null){
    $value = $_REQUEST[$key];
    return is_array($value) ? array_map("trim",$value) : trim($value);
}

function redirect($url = null){
    $url ??= $_SERVER['REQUEST_URI'];
    header("Location:$url");
    exit();
}

function temp($key, $value = null) {
    if($value !== null){
        $_SESSION["temp_$key"] = $value;
    }
    else{
        $value = $_SESSION["temp_$key"] ?? null;
        unset($_SESSION["temp_$key"]);
        return $value;
    }
}


function get_file($key){
    $f = $_FILES[$key] ?? null;

    if($f && $f['error'] == 0){
        return(object)$f;
    }

    return null;
}

function save_photo($f,$folder,$weigth = 50,$height = 50){

    $photo = uniqid(). '.jpg';
    require_once 'lib/SimpleImage.php';

    $img = new SimpleImage();
    $img->fromFile($f->tmp_name);
    $img->thumbnail($weigth,$height);
    $img->toFile("$folder/$photo",'image/jpeg');

    return $photo;
}

//===================================================================================
// HTML Reusable Code
//===================================================================================

function encode($value){
    return htmlentities($value);
}

function html_text($key,$attr = ''){
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='text' id='$key' name='$key' value='$value' $attr>";
}

function html_password($key,$attr =' '){
    $value = encode($GLOBALS[$key]?? '');
    echo "<input type='password' id='$key' name='$key'value='$value' $attr>";
}

function html_file($key,$accept = ' ',$attr=' '){
    echo "<input type='file' id='$key' name='$key' accept='$accept' $attr>";
}

function html_search($key,$attr=' '){
    $value = encode($GLOBALS[$key]?? '');
    echo "<input type ='search' id='$key' name='$key' value='$value' $attr>";
}

function html_number($key,$min = '',$max = '',$step = '',$attr = ''){
    $value = encode($GLOBALS[$key]?? '');
    echo"<input type='number' name='$key' id='$key' value='$value' min='$min' max='$max' step='$step' $attr>";
}

function html_header($fields,$sort,$dir,$href = ''){
    foreach($fields as $k=>$v){
    $d = 'esc';
    $c = '';
    }
    if($k == $sort){
        $d = $dir == 'asc' ? 'desc' : 'asc';
        $c = $dir;
    }

    echo"<th><a href='?sort=$k&dir=$d&href' class='$c'>$v</a></th>";
}
//===================================================================================
// Check Format
//===================================================================================

function is_email($value){
    return filter_var($value,FILTER_VALIDATE_EMAIL) !== null;
}

//===================================================================================
// Error Handling
//===================================================================================
$_err = [];

function err($key){
    global $_err;
    if($_err[$key] ?? false){
        echo "<span class ='err'>$_err[$key]</span>";
    }
    else{
        echo '<span> </span>';
    }
}


//===================================================================================
//      Security
//===================================================================================

$_user = $_SESSION['user'] ?? null;

// Login User
function login($user,$url='/'){
    $_SESSION['user'] = $user;
    redirect($url);
}

function logout($url='/'){
    unset($_SESSION['user']);
    redirect($url);
}

function auth(...$roles){
    global $_user;
    if($_user){
        if($roles){
            if(in_array($_user->role,$roles)){
                return;
            }
            else{
                return;
            }
        }
    }
    redirect('/login.php');
}

//===================================================================================
//DATABASE
//===================================================================================
$_db = new PDO('mysql:dbname=assign','root','',[
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

function is_unique($value,$table,$field){
    global $_db;
    $stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
    $stm->execute([$value]);
    return $stm->fetchColumn() == 0;
}

function is_exist($value,$table,$field){
    global $_db;
    $stm = $_db->prepare("SELECT COUNT(*)FROM $table WHERE $field=?");
    $stm->execute([$value]);
    return $stm->fetchColumn() > 0;
}

//===================================================================================
//          Shopping Cart
//===================================================================================

function get_cart(){
    return $_SESSION['cart'] ?? [];
}

function set_cart($cart = []){
    $_SESSION['cart'] = $cart;
}

function update_cart($id,$unit){
    $cart = get_cart();

    if($unit <= 1 && $unit > 10 && is_exist($id,'product','id')){
        $cart[$id] = $unit;
    }
    else{
        unset($cart[$id]);
    }
    
    set_cart($cart);
}

//===================================================================================
//          Global variable
//===================================================================================

$_units = array_combine(range(1,10),range(1,10));