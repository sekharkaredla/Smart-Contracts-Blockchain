<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\CredentialProvider;
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
session_start();
if(!isset($_POST['SubmitButton'])){
$adminid = $_POST['adminid'];
$adminpass = $_POST['adminpass'];
if($adminid != 'admin' || md5($adminpass) != '21232f297a57a5a743894a0e4a801fc3')
{
  session_destroy();
  header('Location:voting_index.php');
  die();
}
}
else{
  $servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
  $username='uopAdmin123';
  $password='pandu123';
  $database='voterdb';
  $conn=new mysqli($servername,$username,$password,$database);
    if($conn->connect_error){
    session_destroy();
    die('connection failed '.$conn->$connect_error);
  }
  $event_id = $_POST['event_id'];
  $event_name = $_POST['event_name'];
  $sql = 'insert into event_details values("'.$event_id.'","'.$event_name.'",'."1".');';
  echo $sql;
  if ($conn->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    die();
  }
  else{
    echo "Event Details pushed into database<br/>";
  }
  $sql2 = 'create table event_details_'.$event_id.' (username varchar(30),voted boolean);';
  echo $sql2;
  if ($conn->query($sql2) === FALSE) {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
    die();
  }
  else{
    echo "Table created<br/>";
  }
$candiateNames = $_POST['candidate_names'];
// print_r(explode(" ",$candiateNames));
// print_r(count(explode(" ",$candiateNames)));
$candidateAssocArray = explode(" ",$candiateNames);
$candidateLength = count($candidateAssocArray);
$bucket = 'smart-contracts-blockchain';
$keyname = 'candidate_'.$event_id.'.json';
// $provider = CredentialProvider::ini();
// $provider = CredentialProvider::memoize($provider);
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-south-1',
    'credentials' => [
      'key' => getenv('AWS_ACCESS_KEY'),
      'secret' => getenv('AWS_SECRET_ACCESS_KEY')
    ]
]);
$outputObject = array();
$outputObject['candidateDetails'] = array();
$outputObject['candidateDetails']['candidates'] = $candidateAssocArray;
$outputObject['candidateDetails']['candidateLength'] = $candidateLength;
// print_r(json_encode($outputObject));
try {
    // Upload data.
    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'Body'   => json_encode($outputObject),
        'ContentType' => 'text/plain',
        'ACL'    => 'public-read'
    ]);

    // Print the URL to the object.
    echo "SUCCESS:Pushed to S3 <br/>";
    echo $result['ObjectURL'] . PHP_EOL;
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
  header('Location:voting_index.php');
// $myfile = fopen("voter_event.txt", "w");
// fwrite($myfile,$event_id);
// fclose($myfile);


// exec("sudo -u root -S bash /home/sekhar/Desktop/smart-contracts-blockchain/sample.sh < ~/.sudopass/sudopass.txt");
// $out = shell_exec('/usr/local/bin/pm2 start /Users/roshni/Desktop/JPMC_Project/smart-contracts-blockchain/notesetup.js -- '.$event_id);
// echo $out;
die();
};
?>
        

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
    <title>Admin Page</title>
</head>
<script src="chartGeneration.js"></script>
<!-- <script>
    //web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545")); //for local
function display(event_id) {
  web3 = new Web3(
    new Web3.providers.HttpProvider("http://54.213.179.152:8545")
  ); //for aws
  abi = JSON.parse(
    '[{"constant":true,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"validVoter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"totalVotesFor","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"voters","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"validCandidate","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"votesReceived","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"setVoted","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"candidate","type":"bytes32"},{"name":"voterHash","type":"bytes32"}],"name":"voteForCandidate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"candidateList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"candidateNames","type":"bytes32[]"},{"name":"voterNames","type":"bytes32[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]'
  );
  VotingContract = web3.eth.contract(abi);
  var candidates = {};
  var contractAddress = "";
  const url_contract =
    "https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/contract_" +
    event_id +
    ".json";

  const url_candidate =
    "https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/candidate_" +
    event_id +
    ".json";

  function getNames(handle) {
    $.ajax({
      type: "GET",
      url: url_candidate,
      async: false,
      contentType: "application/json",
      dataType: "json",
      success: function(json) {
        handle(json);
      },
      error: function(e) {
        alert("error");
      }
    });
  }
  function getContract(handle) {
    $.ajax({
      type: "GET",
      url: url_contract,
      async: false,
      contentType: "application/json",
      dataType: "json",
      success: function(json) {
        handle(json);
      },
      error: function(e) {
        alert("error");
      }
    });
  }
  getNames(function(data) {
    var length = data.candidateDetails.candidateLength;
    var candidateList = data.candidateDetails.candidates;
    for (var i = 0; i < length; i++) {
      var temp = i + 1;
      candidates[candidateList[i]] = "candidate-" + temp;
    }
  });

  getContract(function(data) {
    contractAddress = data.contract;
  });
  contractInstance = VotingContract.at(contractAddress);
  console.log(candidates);
  console.log(contractAddress);
  var mydataPoints = [];
  for (var name in candidates) {
    var tempDict = {};
    tempDict["y"] = contractInstance.totalVotesFor.call(name).toString();
    tempDict["label"] = name;
    mydataPoints.push(tempDict);
  }
  console.log(mydataPoints);

  console.log("onclck", event_id);
  var chart = new CanvasJS.Chart("mcontent", {
    animationEnabled: true,
    title: {
      text: "Event: " + event_id
    },
    data: [
      {
        type: "pie",
        startAngle: 240,
        yValueFormatString: '##0.00"%"',
        indexLabel: "{label} {y}",
        dataPoints: mydataPoints
      }
    ]
  });
  chart.render();
  console.log($('#myModal'));
  jQuery.noConflict();
jQuery( document ).ready(function( $ ) {
  // Code that uses jQuery's $ can follow here.
  $('#myModal').modal();
});
  
}

</script> -->
<script type="text/javascript">
    function end_event(event_id){
            console.log('end_event');
            $.ajax({
                type: 'POST',
                url: 'end_event.php',
                success: function(data) {
                    console.log('event ended');
                },
                  statusCode: {
                        404: function() {
                            console.log( "page not found" );
                                }
                            }
            });
    }
</script>
<body style="background: linear-gradient(to right, #de6161, #2657eb);">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="menu navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="menu-btn nav-link" href="#create_event">Create Event</a>
                </li>
                <li class="nav-item">
                    <a class="menu-btn nav-link" href="#all_events">All Events</a>
                </li>
                <li class="nav-item">
                    <a class="menu-btn nav-link" href="#misc">Misc</a>
                </li>
                <li class="nav-item">
                    <a class="menu-btn nav-link" onclick="location.href = 'voting_index.php'" >Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="menu-content container" id="create_event">
        <div class="paper" style="margin-top: 10%; padding: 2em;">
            <center>
                <h3>Admin</h3>
            </center>
            <form action="" method="post">
                <div class="form-group">
                    <label for="evid">Event ID</label>
                    <input type="text" class="form-control myinput1" name="event_id" id="evid" placeholder="Enter event id" required/>
                </div>
                <div class="form-group">
                    <label for="evname">Event Name</label>
                    <input type="text" class="form-control myinput1" name="event_name" id="evname" placeholder="Enter event name" required/>
                </div>
                <div class="form-group">

                    <label for="cnid">Candidate Names</label>
                    <input type="textarea" class="form-control myinput1" name="candidate_names" id="cnid" placeholder="Enter candidate names"
                        required/>
                </div>
                <input type="submit" style="margin-top: 3em" class="btn btn-primary btn-lg btn-block mybutton2" value="Submit" name="SubmitButton" />
            </form>
        </div>
    </div>
    <div class="menu-content container" id="all_events"> 
        <div class="paper" style="margin-top: 1em">
            <div class="table-responsive">
                <center>
                    <h4>List of all Events</h4>
                </center>
                <table class="table table-striped">
                    <tbody>
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
                            $sql="select * from event_details";
                            $result = $conn->query($sql);
                            function display($x){
                                return "$x";
                            }
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo"<tr>";
                                    echo'<td><div>'.$row['event_name'].' <button class="btn btn-primary mybutton2" style="float: right;" onclick="display(\''.$row['event_id'].'\')">more</button><button class="btn btn-primary mybutton2" style="float: right;" id="end_event_button" onclick="end_event(\''.$row['event_id'].'\')">end</button></div></td>'; 
                                    echo"</tr>";
                                }
                            }
                            $conn->close();
                        ?>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
    <div class="menu-content container" id="misc"> 
        Misc
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" style="padding: 1em" role="document">
            <div class="modal-content" id="mcontent">
            </div>
        </div>
    </div>
    <script>
        var $content = $('.menu-content');
        function showContent(selector) {
            $content.hide();
            $(selector).show();
        }
        $('.menu').on('click', '.menu-btn', function(e) {
            showContent(e.currentTarget.hash);
            e.preventDefault();
        });
        showContent("#create_event");
    </script>
</body>
<!-- <script src="./votes.js"></script> -->

</html>
