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
  header('Location:index.php');
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
  header('Location:index.php');
// $myfile = fopen("voter_event.txt", "w");
// fwrite($myfile,$event_id);
// fclose($myfile);


// exec("sudo -u root -S bash /home/sekhar/Desktop/smart-contracts-blockchain/sample.sh < ~/.sudopass/sudopass.txt");
// $out = shell_exec('/usr/local/bin/pm2 start /Users/roshni/Desktop/JPMC_Project/smart-contracts-blockchain/notesetup.js -- '.$event_id);
// echo $out;
die();
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
    <title>Admin Page</title>
</head>

<body style="  background: linear-gradient(to right, #56ccf2, #2f80ed);">
    <div class="container">
        <div class="paper" style="margin-top: 10%; ">
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
                <input type="submit" class="btn btn-outline-dark btn-lg btn-block mybutton1" value="Submit" name="SubmitButton" />
            </form>
        </div>
    </div>
</body>

</html>
