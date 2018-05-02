<?php
session_start();
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
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <nav>
    <div class="nav-wrapper" style="padding-left: 8px">
      <a href="#" class="brand-logo">Electrol Voting CBIT</a>
    </div>
  </nav>
  <div style="padding: 16px">
    <h4>Candidate List</h4>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Candidate</th>
            <th>Votes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Aijaaz</td>
            <td id="candidate-1"></td>
          </tr>
          <tr>
            <td>Sekhar</td>
            <td id="candidate-2"></td>
          </tr>
          <tr>
            <td>Pranith</td>
            <td id="candidate-3"></td>
          </tr>
          <tr>
            <td>Alekhya</td>
            <td id="candidate-4"></td>
          </tr>
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
            <input id="voterHash" type="text" class="validate" value="<?php echo htmlspecialchars($_SESSION['voter_hash']); ?>" readonly>
            <label for="voterHash">Voter Hash</label>
          </div>
          <center>
            <a class="waves-effect waves-light btn" onclick="voteForCandidate()">Vote</a>
          </center>
        </div>
      </form>
    </div>
  </div>
</body>
<script src="https://cdn.rawgit.com/ethereum/web3.js/develop/dist/web3.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="./index.js"></script>

</html>