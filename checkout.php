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
		$_SESSION['logged_in'] = TRUE;
	}
	
	if(!isset($_SESSION['pencil'])) {
		$_SESSION['pencil'] = 0;
	}
	
	if(!isset($_SESSION['notebook'])) {
		$_SESSION['notebook'] = 0;
	}
	
	if(isset($_POST['pencil'])) {
		$_SESSION['pencil']++;
		unset($_POST['pencil']);
	}
?>
<html>
	<head>
		<title>Checkout</title>
	</head>
	<body>
		<h1> Checkout </h1>
		<p>
		<?php
			echo '<br><br>' ;
			if (isset($_SESSION['username'])) {
				echo "Logged in as: " ;
				echo $_SESSION['username'] ;
				echo '<form name="input" action="/First.php" method="post">
				<input type="submit" name="logout" value="Log out">
				</form>';
				echo '<form name="input" action="/receipt.php" method="post">
					Card number:</br> <input type="text" name="cardNumber">
					<br>
					Good thru (mm/yy): </br> <input type="text" name="month">
					 / <input type="text" name="year">
					<br>
					CVC/CVV code:</br><input type="text" name="cvccvv">
					<br>
					Re-enter password:</br><input type="password" name="pwd">
					</br>
					<input type="submit" value="Confirm payment">
				</form>';
			} else {
				echo 'You must be logged in to check out. </br>';
				echo '<a href="/login.php">Log in</a><br>' ;
				echo '<a href="/createAccount.php">Create Account</a>' ;
			}
			echo '<br><br>' ;
		?>
		<br><a href="/First.php">Main page</a>
		</p>
		<p>
		</p>
		
	</body>
</html>
