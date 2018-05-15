<?php
$servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
$username='uopAdmin123';
$password='pandu123';
$database='voterdb';
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
/*if(isset($_POST['eventlist'])){$eventlist=$_POST['eventlist'];echo "gh".$eventlist;}
if(isset($_POST['username'])){$uname=$_POST['username'];echo "ch".$uname;}
if(isset($_POST['password'])){$pass=$_POST['password'];echo "dh".$pass;}*/

$eventid = $_POST['eventlist'];
$voter_hash=$_POST['voter_hash'];
$pass = md5($_POST['password']);
$sql2 = "INSERT INTO voter_credentials VALUES ('{$_POST['username']}','{$pass}','{$voter_hash}','{$eventid}')";
if ($conn->query($sql2) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
}
$sql1 = "INSERT INTO event_details_".$eventid." VALUES('{$_POST['username']}',false)";
if ($conn->query($sql1) === TRUE){
	echo "done";
}
else{
	echo "not done";
}
$conn->close();
header('Location:voting_index.php');
die();
?>
