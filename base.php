<?php

date_default_timezone_set('Asia/Kuala_Lumpur'); 
session_start();

function is_get(){
    return $_SERVER['REQUEST_METHOD'] = 'GET';
}

function is_post(){
    return $_SERVER['REQUEST_METHOD'] = 'POST';
}