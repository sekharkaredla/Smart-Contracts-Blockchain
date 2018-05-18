<?php
  session_start();
?>
<html>
<head>
  <title>Bidding System CBIT</title>
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

<body class="container" style="background:linear-gradient(to right, #02111d, #037bb5, #02111d); padding: 2em; margin-top: 1%;">
<input type="hidden" id="bidderHash" value = "<?php echo $_SESSION['bidder_hash'] ?>"/>
  <div>
    <div class="paper" style="margin-top: 1em">
        <div class="table-responsive">
            <center>
                <h4>List of all Events</h4>
            </center>
            <table class="table table-striped">
                <tbody>
                    <thead>
                        <tr>
                        <th scope="col">Event Name</th>
                        <th scope="col">Initial Price</th>
                        <th scope="col">Enter Bid</th>
                        <th scope="col">Place Bid</th>
                        </tr>
                    </thead>
                    <?php
                        $servername='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com';
                        $username='uopAdmin123';
                        $password='pandu123';
                        $database='bidDB';
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
                                // echo'<td><div style="display: flex; align-items: baseline"><p>'.$row['event_name'].'</p><p>'.$row['event_price'].'</p><input class="myinput1" type="number" id="'.$row['event_id'].'_bid" /><button class="btn btn-primary mybutton2" style="float: right;" onclick="placeBid(\''.$row['event_id'].'\')">Bid</button></div></td>';
                                echo '<td>'.$row['event_name'].'</td>';
                                echo '<td>'.$row['event_price'].'</td>';
                                echo '<td><input class="myinput" type="number" id="'.$row['event_id'].'_bid" /></td>';
                                echo '<td><button class="btn btn-primary mybutton2" onclick="placeBid(\''.$row['event_id'].'\')">Bid</button></td>';
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
</body>
<script src="../web3.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="./bidding.js"></script>
</html>
