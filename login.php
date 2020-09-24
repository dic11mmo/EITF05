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
		echo "sessionen ej servergenererad";
		session_destroy();
		session_start();
	}
	$_SESSION['ServGen'] = true;
?>
<html>
	<head>
		<title>Log in</title>
	</head>
	<body>
		<h1> Log in </h1>
		<br>
		<form name="input" action="/loginResult.php" method="post">
		Username: <input type="text" name="username">
		<br>
		Password: <input type="password" name="pwd">
		<br>
		<input type="submit" value="Log in">
		</form>
		<p>
		<?php //start PHP code
	
	echo '<br><br>' ;
		//unset($_SESSION['username']) ;
		//$_SESSION['username'] = 'hgfj' ;
		if (isset($_SESSION['username'])) {
			echo "Logged in as: " ;
			echo $_SESSION['username'] ;
		}
		echo '<br><br>' ;
		?>
		</p>
	</body>
</html>