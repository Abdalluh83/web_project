<?php
session_start();
$errors = [];
if (empty($_REQUEST["name"])) $errors["name"] = "Name is Required";
if (empty($_REQUEST["email"])) $errors["email"] = "email is Required";
if (empty($_REQUEST["pw"])||empty($_REQUEST["pc"]))
{$errors["pw"]="password and password confirmation is reqierd";}
else if( $_REQUEST["pw"] != $_REQUEST["pc"]){
$errors["pc"]="password and password confirmation is reqierd";
}

$name = htmlspecialchars(trim($_REQUEST["name"]));
$email = filter_var($_REQUEST["email"],FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_REQUEST["pw"]);
$password_confirmation = htmlspecialchars($_REQUEST["pc"]);


if(!empty($_REQUEST["email"]) && !filter_var($_REQUEST["email"],FILTER_SANITIZE_EMAIL)) $errors["email"] = "Email Invalid Formate";

if (empty($errors)) {
    require_once('classs.php');
    try {
        $rslt = Subscriber::register($name,$email,$password,$phone);
        header("location:index.php");
    } catch (\Throwable $th) {
        header("location:index.php");
    }

}else{
    $_SESSION["errors"]=$errors;
    header("location:regestier.php");
}