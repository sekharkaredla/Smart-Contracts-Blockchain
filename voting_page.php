<?php
require 'vendor/autoload.php';
session_start();
if(!$_SESSION['user']){
  header('Location:index.html');
  die();
}
$fileContents = file_get_contents("https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/candidate_".$_SESSION['event_id'].".json");
$json = json_decode($fileContents, true);
$candidateList = $json['candidateDetails']['candidates'];
$candidateLength = $json['candidateDetails']['candidateLength'];
?>
<html>
<head>
  <title>Electrol Voting CBIT</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <!-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'> -->
</head>

<body>
  <input type="hidden" id="event_id" value = "<?php echo $_SESSION['event_id'] ?>"/>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <nav>
    <div class="nav-wrapper" style="padding-left: 8px">
      <a href="#" class="brand-logo">Electrol Voting CBIT</a>
    </div>
  </nav>
  <div style="padding: 16px">
    <h4><?php echo htmlspecialchars($_SESSION['event_name']); ?></h4>
    <h5>Candidate List</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Candidate</th>
            <th>Votes</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for($temp=0;$temp<$candidateLength;$temp++)
          {
            $temp2 = $temp +1;
          echo "<tr>";
            echo "<td>".$candidateList[$temp]."</td>";
            echo "<td id = \"candidate-".$temp2."\"></td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <div>
      <form>
        <div class="row">
          <div class="input-field col s6">
            <input id="candidate" type="text" class="validate">
            <label for="candidate">Candidate Name</label>
          </div>
          <div class="input-field col s6">
            <input id="voterHash" type="text" class="validate" value="<?php echo htmlspecialchars($_SESSION['voter_hash']); ?>">
            <label for="voterHash">Voter Hash(Self Generated)</label>
          </div>
          <center>
            <a class="waves-effect waves-light btn" onclick="voteForCandidate()">Vote</a>
          </center>
        </div>
      </form>
    </div>
  </div>
</body>
<script src="./web3.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="./voting.js"></script>

</html>
