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
  $servername='localhost';
  $username='voter_admin';
  $password='password';
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