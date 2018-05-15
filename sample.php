<?php
require 'vendor/autoload.php';
session_start();
if(!$_SESSION['user']){
  header('Location:voting_index.php');
  die();
}
$fileContents = file_get_contents("https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/candidate_".$_SESSION['event_id'].".json");
$json = json_decode($fileContents, true);
$candidateList = $json['candidateDetails']['candidates'];
$candidateLength = $json['candidateDetails']['candidateLength'];
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
	function voteForCandidate() {
		candidateName = $("#candidate").val();
		console.log(candidateName);
	}
</script>
<form>
<select id="candidate" class="form-control myinput">
              <?php
                for($temp=0;$temp<$candidateLength;$temp++)
                {
                  $temp2 = $temp +1;
                  echo"<option class=\"options\" value=\"candidate-".$temp2."\" >".$candidateList[$temp]."</option>";
                }
            ?>
            </select>
<input type="button" class="btn btn-primary btn-lg btn-block mybutton2" value="Vote" onclick="voteForCandidate()"/>
</form>