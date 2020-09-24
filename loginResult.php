<!DOCTYPE html>
<?php
	session_start();
	session_regenerate_id();
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

	$_SESSION['pwd'] = '';
	if(isset($_POST['pwd'])) {
		$_SESSION['pwd'] = $_POST['pwd'];
	}
	
?>
<html>
	<head>
		<title>Result of login</title>
	</head>
	<body>
		<h1> Result of login </h1>
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
	$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE Username = ? AND Password = ?"); 
	if ($stmt === FALSE) {
		die(mysqli_error($db));
	}
	mysqli_stmt_bind_param($stmt, 'ss', $_POST['username'], hash('sha256', $_SESSION['pwd']));
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $u_address, $u_pass, $u_name);
	mysqli_stmt_fetch($stmt);
	
	if($u_name) {
		session_regenerate_id();
		echo "You have successfully logged in as user: ";
		echo $u_name;
			$_SESSION['username'] = '';
	if(isset($_POST['username'])) {
		$_SESSION['username'] = $_POST['username'] ;
	}
				echo '<form name="input" action="/First.php" method="post">
		<input type="submit" name="logout" value="Log out">
		</form>';
	} else {
		echo "Either the username does not exist, or the password was incorrect.";
		echo '<br><a href="/login.php">Log in</a><br>' ;
		echo '<a href="/createAccount.php">Create Account</a>' ;
	}
	
	echo '<br><br>' ;
		?>
		<br>
				<form name="input" action="/First.php" method="post">
		 Pencil. 8$<input type="submit" name="pencil" value="Add to cart">
		</form>
				<br>
				<form name="input" action="/First.php" method="post">
		 Notebook. 14$<input type="submit" name="notebook" value="Add to cart">
		</form>
		<br>
		<a href="/cart.php">Shopping cart</a>
		</p>
	</body>
</html>
