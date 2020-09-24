<!DOCTYPE html>
<?php
	session_start();
	if(! isset($_SESSION['ServGen'])) {
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
		}
		echo "sessionen ej servergenererad";
		session_destroy();
		session_start();
	}
	$_SESSION['ServGen'] = true;
?>
<html>
	<head>
		<title>Create Account</title>
	</head>
	<body>
		<h1> Create Account </h1>
		<br>
		<form name="input" action="/createAccountSubmitted.php" method="post">
		Username: <input type="text" name="username">
		<br>
		Password: <input type="password" name="pwd">
		<br>
		Home Address: <input type="text" name="address">
		<br>
		<input type="submit" value="Create">
		</form>
		<p>
		<?php //start PHP code
	echo '<br>' ;
		if (isset($_SESSION['username'])) {
			echo "Logged in as: " ;
			echo $_SESSION['username'] ;
			echo '<form name="input" action="/First.php" method="post">
			<input type="submit" name="logout" value="Log out">
			</form>';
		} else {
			echo '<a href="/login.php">Log in</a>' ;
		}
		?>
		</p>
	</body>
</html>