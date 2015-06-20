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
		
		//check username and pw
		$chckPW = mysqli_query($conn, "SELECT * FROM users WHERE user = '$username' AND pw = '$enc_pass'");
		$rowPW = mysqli_num_rows($chckPW);
			if ($rowPW != 0) {
			session_start();
			$_SESSION['user']=$username;
			header('Location: member.php');
			} else {
			$message = "Invalid Username or Password";
			}
		mysqli_close($conn);	
	}
?>

<html>
<body>
<h1>Login for Free Bitcoins!</h1>
<br>
<form name="login" method="post" action="login.php">
Username: <input type="text" name="username" maxlength="15" /><br>
Password: <input type="password" name="pw" /><br>
<input type="submit" name="submit" value="Login" />
</form>
<?php echo $message; ?><br>
<a href="register.php">Not Registered? Create an Account </a>
</body>
</html>