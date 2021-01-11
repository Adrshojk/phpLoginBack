<?php
require_once __DIR__.'/db.php';
$content=trim(file_get_contents('php://input'));
$decoded=json_decode($content,true);
if($_SERVER['REQUEST_METHOD']=="GET"){
    
    $response['status']=true;
    $response['message']='not allowed';
}else if($_SERVER['REQUEST_METHOD']=="POST") {
    // echo "Post method";
    $userId=$decoded['userId'];
    $getUser="SELECT * FROM `users` WHERE `userId`='$userId'";
    $res=mysqli_query($dbcon,$getUser);
    if(mysqli_num_rows($res)>0){
        $userObj=mysqli_fetch_assoc($res);
    }
    $response['status']=true;
    $response['data']=$userObj;
    if($decoded['type']=='update'){
            $age=$decoded['age'];
            $dob=$decoded['dob'];
            $contact=$decoded['contact'];
            $sql = "UPDATE `users` SET `age`='$age',`dob`='$dob',`contact`='$contact' WHERE `userId`='$userId' ";
            $getQry=mysqli_query($dbcon,$sql);
    
            if($getQry){
                $getUser="SELECT * FROM `users` WHERE `userId`='$userId'";
    $res=mysqli_query($dbcon,$getUser);
    if(mysqli_num_rows($res)>0){
        $userObj=mysqli_fetch_assoc($res);
    }
    $response['status']=true;
    $response['data']=$userObj;
                
                $response['status']=true;
                $response['message']='Updated successfully';
                $response['data']=$userObj;
            }
            else{
                $response['status']=false;
                $response['message']=mysqli_error($dbcon);
            }

        }
    
}else{
    http_response_code(405);
}

// header('Content-Type: application/json; charset:UTF-8');
echo json_encode($response);
