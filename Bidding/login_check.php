
<html>

<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
	 crossorigin="anonymous">
     <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
     <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
	 crossorigin="anonymous"></script>

	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="./web3.js"></script>
    <!-- <title>Admin Page</title> -->
</head>
<body>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>Oops! You have already voted.</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.href = './voting_index.php'">Close</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
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
  $database='bidDB';
  $conn=new mysqli($servername,$username,$password,$database);
    if($conn->connect_error){
    session_destroy();
    die('connection failed '.$conn->$connect_error);
  }
   $user=test($_POST['username']);
  $pass=test($_POST['password']);
  $sql="select * from bidder_credentials where username='".$user."'";
  $result=$conn->query($sql);
  if($result->num_rows>0){
    $row=$result->fetch_assoc();
    if($row['password']==md5($pass)){
      $_SESSION['user']=$user;
      $_SESSION['bidder_hash']=$row['bidder_hash'];
      // $sql="select event_name from event_details where event_id='".$row['event_id']."'";
      // $result2=$conn->query($sql);
      // $event_row=$result2->fetch_assoc();
      // $_SESSION['event_id']=$row['event_id'];
      // $_SESSION['event_name']=$event_row['event_name'];
      // $sql = "select voted from event_details_".$row['event_id']." where username='".$user."'";
      // $result3=$conn->query($sql);
      // // $voted_row=$result3->fetch_assoc();
      // if($voted_row['voted']==1)
      // {
      //   echo "<script>
      //   // alert('Oops! You have already voted.');
      //   $('#myModal1').modal();
      //   // window.location.href='voting_index.php';
      //   </script>";
      //   // alert('you have already voted');
      //   // header('Location:index.php');
      //   session_destroy();
      //   die();
      // }
      header('Location:bidding_page.php');
      die();
    }
    else{
      session_destroy();
      header('Location:bidding_index.php');
      die();
    }
  }
  else{
    session_destroy();
    header('Location:bidding_index.php');
    die();
  }
}
?>