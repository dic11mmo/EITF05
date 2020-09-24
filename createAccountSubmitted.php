<!DOCTYPE html>
<?php
	session_start();
	if(! isset($_SESSION['ServGen'])) {
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
		session_start();
	}
	$_SESSION['ServGen'] = true;
	if(isset($_POST['username'])) {
		$_SESSION['username'] = $_POST['username'] ;
	}
	if(isset($_POST['pwd'])) {
		$_SESSION['pwd'] = $_POST['pwd'] ;
		unset($_POST['pwd']);
	}
	if(isset($_POST['address'])) {
		$_SESSION['address'] = $_POST['address'] ;
	}
?>
<html>
	<head>
		<title>Create Account Submitted</title>
	</head>
	<body>
		<h1> Create Account Submitted </h1>
		<br>
		<p>
		<?php
		$mysqliuser = ini_get("mysqli.default_user");
		$mysqlihost = ini_get("mysqli.default_host");
		$mysqlipw = ini_get("mysqli.default_pw");	
		$db = mysqli_connect($mysqlihost, $mysqliuser, $mysqlipw, $mysqliuser);
		if(!$db) {
			echo "gick ej att ansluta till databasen";
		}
		$stmt = mysqli_prepare($db, "INSERT INTO users (Address, Password, Username) VALUES(?, ?, ?)");
		if ($stmt === FALSE) {
			die(mysqli_error($db));
		}
		mysqli_stmt_bind_param($stmt, 'sss', $_SESSION['address'], hash('sha256', $_SESSION['pwd']), $_SESSION['username']);
		mysqli_stmt_execute($stmt);
		echo '<br>';
			if (isset($_SESSION['username'])) {
				echo "Logged in as: " ;
				echo $_SESSION['username'] ;
				echo '<form name="input" action="/First.php" method="post">
					<input type="submit" name="logout" value="Log out">
					</form>';
				echo '<br><a href="/First.php">Main page</a>';
			} else {
				echo '<a href="/login.php">Log in</a>' ;
			}
			?>
			</p>
	</body>
</html>