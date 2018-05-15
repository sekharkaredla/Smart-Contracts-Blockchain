<?php
	$servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
	$username='uopAdmin123';
	$password='pandu123';
	$database='voterdb';
	echo "yo";
	$conn=new mysqli($servername,$username,$password,$database);
	if($conn->connect_error){
		die('connection failed '.$conn->$connect_error);
	}
	$sql = 'update event_details set running=true where event_id="'.$_GET['event_id'].'"';
  echo $sql;
  if ($conn->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    die();
  }
  else{
    echo "Voting ended<br/>";
    header('Location:admin.php');
  }
?>