<?php
	$conn = mysqli_connect("localhost", "dbuser", "dbpassword", "dbname");
	if (mysqli_connect_errno()){
	echo "Connection to DB failed" . mysqli_connect_error();
	}

	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['pw'];
		
		$username = mysqli_real_escape_string($conn, $username);
		$password = mysqli_real_escape_string($conn, $password);
		$enc_pass = md5($password);
		
		//check for duplicate usernames
		$dupName = mysqli_query($conn, "SELECT * FROM users WHERE user = '$username'");
		$rowName = mysqli_num_rows($dupName);
			if ($rowName != 0) {
			$message = "Username is already in use, pick another";
			} else {
		
		mysqli_query($conn, "INSERT INTO users (user, pw) VALUES ('$username', '$enc_pass')");
		$message = "Account Successfully Created";
		mysqli_close($conn);
		}
	}
?>

<html>
<body>
<h1>Register for Free Bitcoins!</h1>
<br>
<form name="register" method="post" action="register.php">
Username: <input type="text" name="username" maxlength="15" /><br>
Password: <input type="password" name="pw" /><br>
<input type="submit" name="submit" value="Register" />
</form>
<?php echo $message; ?><br>
<a href="login.php">Already Registered? Login Here </a>
</body>
</html>