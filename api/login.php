<?php
require_once __DIR__.'/db.php';

$content=trim(file_get_contents('php://input'));
$decoded=json_decode($content,true);

$email=$decoded['email'];
$password=$decoded['password'];

$loginQry="SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
$res=mysqli_query($dbcon,$loginQry);
if(mysqli_num_rows($res)>0){
    $userObj=mysqli_fetch_assoc($res);
    $response['status']=true;
        $response['message']='successfully logged in';
        $response['data']=$userObj;
    }
    else{
    $response['status']=false;
        $response['message']='login failed';
    }
    header('Content-Type: application/json; charset:UTF-8');
    echo json_encode($response);
