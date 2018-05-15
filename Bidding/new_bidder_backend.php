<?php
$servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
$username='uopAdmin123';
$password='pandu123';
$database='bidDB';
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
/*if(isset($_POST['eventlist'])){$eventlist=$_POST['eventlist'];echo "gh".$eventlist;}
if(isset($_POST['username'])){$uname=$_POST['username'];echo "ch".$uname;}
if(isset($_POST['password'])){$pass=$_POST['password'];echo "dh".$pass;}*/

$bidder_hash=$_POST['bidder_hash'];
$pass = md5($_POST['password']);
$sql2 = "INSERT INTO bidder_credentials VALUES ('{$_POST['username']}','{$pass}','{$bidder_hash}')";
if ($conn->query($sql2) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
}
header('Location:bidding_index.php');
die();
?>
