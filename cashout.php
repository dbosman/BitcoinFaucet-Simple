<?php
session_start();
$user = $_SESSION['user'];

	//Connect to Database
	$conn = mysqli_connect("localhost", "dbuser", "dbpassword", "dbname");
	if (mysqli_connect_errno()){
	echo "Connection to DB failed" . mysqli_connect_error();
	}
	
	//check for self navigation
	$truLogin = mysqli_query($conn, "SELECT * FROM users WHERE user ='$user'");
	$rowTru = mysqli_num_rows($truLogin);
		if ($rowTru == 0) {
		header ('Location: login.php');
		}
		
	//Get the user balance
	$balQuery = mysqli_query($conn, "SELECT balance FROM users WHERE user = '".$_SESSION['user']."'");
	$rowBal= mysqli_fetch_row($balQuery);	
	
	if(isset($_POST['submit'])){
	//check balance meets minimum DEFAULT IS SET AT 9999 satoshis you can change to whatever you like
		if ($rowBal[0] < 9999) {
			$message = "You do not have enough to cash out.";
		} else {
		//Balance meets minimum send payment
		$address = $_POST['address'];
		$address = mysqli_real_escape_string($conn, $address);
		$amount = $rowBal[0];
		$ID = "1a11a1a1-1aa1aa1a-1aa1-aa1a1";   //YOUR BLOCKCHAIN.INFO USER ID
		$PW = "correcthorsebatterystaple";      //YOUR BLOCKCHAIN.INFO PASSWORD
		$sendPayment = json_decode(file_get_contents("https://blockchain.info/merchant/$ID/payment?password=$PW&to=$address&amount=$amount"), true);
		$txID = "Transaction ID:" . $sendPayment[tx_hash];
		$message = "Payment successfully sent to ";
		
		//update balance to zero
		mysqli_query($conn, "UPDATE users SET balance = 0 WHERE user = '".$_SESSION['user']."'");
		}
	}
?>

<html>
<body>
<h1>Welcome <?php echo $user; ?></h1>
<h3>Minimum to cashout is 10,000 </h3>
<h3>Your current balance is: <?php echo $rowBal[0]; ?></h3>
<h3>Enter your Bitcoin Address:</h3>
<form name="cashout" method="post" action="cashout.php">
<input type="text" name="address" size="34" />
<input type="submit" name="submit" value="Cashout" />
</form>
<h3>Balance: <?php echo $rowBal[0]; ?></h3>
<?php echo $message; echo $address; ?><br>
<?php echo $txID; ?><br>
<a href="logout.php">Logout</a>
</body>
</html>