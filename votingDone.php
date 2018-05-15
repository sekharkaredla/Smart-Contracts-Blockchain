<?php
session_start();
if(!$_SESSION['user']){
  header('Location:voting_index.php');
  die();
  };
$servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
$username='uopAdmin123';
$password='pandu123';
$database='voterdb';
$conn=new mysqli($servername,$username,$password,$database);
if($conn->connect_error){
session_destroy();
die('connection failed '.$conn->$connect_error);
}
$user = $_SESSION['user'];
$event_id = $_SESSION['event_id'];
$sql = "update event_details_".$event_id." set voted = true where username='".$user."'";
if ($conn->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    die();
  }
  else{
    echo "Event Details updated into database<br/>";
  }
session_destroy();
header('Location:voting_index.php');
die();
?>