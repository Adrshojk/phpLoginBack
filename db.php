<?php
$dbcon=mysqli_connect('localhost','root','','login_system');
if($dbcon){
    // echo "{message='connected'}";
}else{
    die('connection failed : '.mysqli_connect_error());
}
?>