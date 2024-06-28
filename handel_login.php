<?php
session_start();
if(!empty($_REQUEST["email"])&& !empty($_REQUEST["password"])){

    require_once('classs.php');
    $user = User::login($_REQUEST["email"] ,md5($_REQUEST["password"]));

    if(!empty($user)){
        $_SESSION["user"] =serialize($user);
    if($user->role == "admin"){
        header("location:frontend/admin/home.php");
}elseif($user->role == "subscriber"){
    header("location:frontend/subscriber/home.php");
}
}
else{
    header("location:index.php");
}

}