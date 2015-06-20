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
	
	//When user clicks claim coin button
	if(isset($_POST['submit'])){
		$time = time(true);
		$prize = 200;  // DEFAULT SET AT 200 SATOSHIS PER CLICK
		
		//check to see when they last collected
		$timeQ = mysqli_query($conn, "SELECT time FROM users WHERE user = '".$_SESSION['user']."'");
		$rowTime = mysqli_fetch_row($timeQ);
			if ($time - $rowTime[0] < 60) { //DEFAULT SET AT 60 SECONDS TO WAIT IN BETWEEN CLICKS
			$message = "You are doing that too often!";
			} else
			{
				//update balance
				mysqli_query($conn, "UPDATE users SET balance = balance + '$prize' WHERE user = '".$_SESSION['user']."'");
				//display updated balance
				$balQuery = mysqli_query($conn, "SELECT balance FROM users WHERE user = '".$_SESSION['user']."'");
				$rowBal= mysqli_fetch_row($balQuery);
				//update time collected
				mysqli_query($conn, "UPDATE users SET time = '$time' WHERE user = '".$_SESSION['user']."'");
			} // end else 
	} // end if post
	
	mysqli_close($conn);

?>

<html>
<body>
<h1>Welcome <?php echo $user; ?></h1>
<form name="claim" method="post" action="member.php">
<input type="submit" name="submit" value="Claim My Coins" />
</form>
<h3>Balance: <?php echo $rowBal[0]; ?></h3>
<?php echo $message; ?><br>
<a href="logout.php">Logout</a> | <a href="cashout.php">Cashout</a>
</body>
</html>