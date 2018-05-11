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
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
	 crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
	 crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
	 crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
	 crossorigin="anonymous"></script>
	<link rel="stylesheet" href="./styles.css">


	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"></head>

<body class="container" style="background: linear-gradient(to right, #de6161, #2657eb); padding: 2em; margin-top: 1%;">
  <input type="hidden" id="event_id" value = "<?php echo $_SESSION['event_id'] ?>"/>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <div class="paper">
  <div style="padding: 16px">
    <center>
    <h2>CBIT Electrol Voting</h2>
</center>
    <h4>Event: <?php echo htmlspecialchars($_SESSION['event_name']); ?></h4>
    <!-- <h5>Candidate List</h5> -->
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Candidate</th>
            <th scope="col">Votes</th>
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
          <div class="form-group col s6">
          <label for="candidate">Candidate Name</label>
            <!-- <input id="candidate" type="text" class="form-control myinput3" placeholder="Enter Candidate Name"> -->
            <select class="form-control myinput">
              <?php
                for($temp=0;$temp<$candidateLength;$temp++)
                {
                  $temp2 = $temp +1;
                  echo"<option class=\"options\" id=\"candidate\" value=\"candidate-".$temp2."\" >".$candidateList[$temp]."</option>"; 
                }
            ?>
            </select>
          </div>
          <div class="form-group col s6">
          <label for="voterHash">Voter Hash(Self Generated)</label>
            <input id="voterHash" type="text" class="form-control myinput3" value="<?php echo htmlspecialchars($_SESSION['voter_hash']); ?>">
          </div>
          
          <!-- <center>
            <a class="waves-effect waves-light btn" onclick="voteForCandidate()">Vote</a>
          </center> -->
          <input type="button" class="btn btn-primary btn-lg btn-block mybutton2" value="Vote" onclick="voteForCandidate()"/>
        
        </div>
      </form>
    </div>
  </div>
  </div>
</body>
<script src="./web3.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="./voting.js"></script>

</html>

