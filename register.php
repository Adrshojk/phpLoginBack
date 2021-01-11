<?php
require_once __DIR__.'/db.php';
$content=trim(file_get_contents('php://input'));
$decoded=json_decode($content,true);
if($_SERVER['REQUEST_METHOD']=="GET"){
    
    $response['status']=true;
    $response['message']='not allowed';
}else if($_SERVER['REQUEST_METHOD']=="POST") {
    // echo "Post method";

    $email=$decoded['email'];
    $name=$decoded['name'];
    $password=$decoded['password'];

        $sql = "INSERT INTO users (email, password, name) VALUES ('$email','$password','$name') ";
        $getQry=mysqli_query($dbcon,$sql);
        if($getQry){
            $userId=mysqli_insert_id($dbcon);
            $response['status']=true;
            $response['message']='Registered successfully';
            $response['userId']=$userId;
        }
        else{
            $response['status']=false;
            $trimmed=substr(mysqli_error($dbcon),0,9)   ;
            if($trimmed=='Duplicate')
            $response['message']='User already exist,try different email';
            else
            $response['message']=mysqli_error($dbcon);
        }
    
}else{
    http_response_code(405);
}

header('Content-Type: application/json; charset:UTF-8');
echo json_encode($response);


?>