<html>

<head>
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
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<title>Voting App</title>
</head>

<body class="container-fluid" style="background: linear-gradient(to right, #de6161, #2657eb); padding: 2em;">
	<div style="margin-top: 1%">
		<div class="paper">
			<center>
				<h2 style="color: #000; margin-top: 1em">Voters Login to Access Distributed Services</h2>
			</center>
			<div class="row" id="logins" style="padding: 8em">
				<div class="col-sm">
					<img src="./user.png" style="height: 16em;" id="userpic" />
					<img src="./admin.png" style="height: 16em; display: none;" id="adminpic" />
				</div>
				<div class="col-sm">
					<div style="margin: 1em">
						<center>
							<input type="checkbox" data-toggle="toggle" data-style="ios" id="switch" data-on="Admin Login > " data-off=" < User Login">
						</center>
						<script>
							$(function () {
								$('#switch').change(function () {
									$("#userlogin").toggle("slow", "swing");
									$("#adminlogin").toggle("slow", "swing");
									$("#userpic").toggle("slow", "swing");
									$("#adminpic").toggle("slow", "swing");
								})
							})
						</script>
					</div>
					<div id="userlogin">
						<form action="login_check.php" method="post">
							<div class="form-group">
								<!-- <label for="uid">Email address</label> -->
								<input type="text" class="form-control myinput" id="uid" name="username" aria-describedby="emailHelp" placeholder="Enter username"
								 required>
							</div>
							<div class="form-group">
								<!-- <label for="pid">Password</label> -->
								<input type="Password" class="form-control myinput" name="password" id="pid" placeholder="Enter password" required>
							</div>
							<input type="submit" class="btn btn-primary btn-lg btn-block mybutton" name="login" value="Login" />
						</form>
					</div>
					<div id="adminlogin" style="display: none;">
						<form method="post" action="admin.php">
							<div class="form-group">
								<!-- <label for="adminid">Admin Username</label> -->
								<input type="text" class="form-control myinput" name="adminid" placeholder="Enter admin username" required>
							</div>
							<div class="form-group">
								<!-- <label for="adminpass">Admin Password</label> -->
								<input type="password" class="form-control myinput" name="adminpass" placeholder="Enter admin password" required>
							</div>
							<input type="submit" class="btn btn-primary btn-lg btn-block mybutton" name="login" value="Login" />
						</form>
					</div>
					<center>
						<span id="signuptextspan">
							<p id="signuptext">Don't have an account? Sign up here</p>
						</span>
						<script>
							$(function () {
								$('#signuptext').click(function () {
									console.log("hello");
									$("#logins").toggle();
									$("#register").toggle();
								})
							})
						</script>
					</center>
				</div>
			</div>
			<div id="register" style="display: none; padding: 8em">
				<div class="row">
					<div class="col-sm">
						<img src="./register.png" style="height: 16em;"/>
					</div>
					<div class="col-sm">
						<div>
							<center>
								<h5>New User Sign Up </h5>
							</center>
							<form   id="reg" method="post" action="new_voter_backend.php">
								<div class="form-group">
									<!-- <label for="uidr">Email addres</label> -->
									<input type="text" class="form-control myinput" id="uidr" name="username" aria-describedby="emailHelp" placeholder="Enter username"
									required>
								</div>
								<div class="form-group">
									<!-- <label for="pidr">Password</label> -->
									<input type="Password" class="form-control myinput" name="password" id="pidr" placeholder="Enter password" required>
								</div>
								<div class="form-group">
									<!-- <label for="ename">Event Name</label> -->
									<select name="eventlist" class="form-control myinput" style="height: 3em" id="el" >
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

											if ($result->num_rows > 0) {
											// output data of each row
											while($row = $result->fetch_assoc()) {
												echo"<option class=\"options\" value=".$row['event_id'].">".$row['event_name']."</option>"; 
											}}
											$conn->close();
										?>
										
									</select>
								</div>
								<input type="submit" class="btn btn-primary btn-lg btn-block mybutton" name="register" value="Register" />
								<center>
									<span id="signuptextspan" >
										<p id="logintext" style="margin-top: 2%">Already have an account? Login here</p>
									</span>
									<script>
										$(function () {
											$('#logintext').click(function () {
												$("#logins").toggle();
												$("#register").toggle();
											})
										})
									</script>
								</center>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>