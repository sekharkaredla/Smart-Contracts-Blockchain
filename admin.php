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
  header('Location:index.html');
  die();
}
}
else{
  $servername='localhost';
  $username='voter_admin';
  $password='pandu123';
  $database='voterdb';
  $conn=new mysqli($servername,$username,$password,$database);
    if($conn->connect_error){
    session_destroy();
    die('connection failed '.$conn->$connect_error);
  }
  $event_id = $_POST['event_id'];
  $event_name = $_POST['event_name'];
  $sql = 'insert into event_details values("'.$event_id.'","'.$event_name.'");';
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
die();
}
?>
<html>
<head>
	<title>Admin Page</title>
</head>
<body>
<form action="" method="post">
  Event Id : <input type="text" name="event_id"/><br/>
  Event Name : <input type="text" name="event_name"/><br/>
  Candidate Names : <input type="textarea" name="candidate_names"/><br/>
  <input type="submit" value = "Submit" name="SubmitButton"/>
</form>
</body>
</html>
