<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
function test($data){
  $data=trim($data);
  $data=stripcslashes($data);
  $data=htmlspecialchars($data);
  return $data;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
  $servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
  $username='uopAdmin123';
  $password='pandu123';
  $database='voterdb';
  $conn=new mysqli($servername,$username,$password,$database);
    if($conn->connect_error){
    session_destroy();
    die('connection failed '.$conn->$connect_error);
  }
   $user=test($_POST['username']);
  $pass=test($_POST['password']);
  $sql="select * from voter_credentials where username='".$user."'";
  $result=$conn->query($sql);
  if($result->num_rows>0){
    $row=$result->fetch_assoc();
    if($row['password']==md5($pass)){
      $_SESSION['user']=$user;
      $_SESSION['voter_hash']=$row['voter_hash'];
      $sql="select event_name from event_details where event_id='".$row['event_id']."'";
      $result2=$conn->query($sql);
      $event_row=$result2->fetch_assoc();
      $_SESSION['event_id']=$row['event_id'];
      $_SESSION['event_name']=$event_row['event_name'];
      header('Location:voting_page.php');
      die();
    }
    else{
      session_destroy();
      header('Location:index.html');
      die();
    }
  }
  else{
    session_destroy();
    header('Location:index.html');
    die();
  }
}
?>