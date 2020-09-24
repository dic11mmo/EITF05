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
?>
<html>
	<head>
		<title>Shopping cart</title>
	</head>
	<body>
		<h1> Shopping cart </h1>
		<p>
		<?php //start PHP code
	echo '<br>
	<br>' ;
		if (isset($_SESSION['username'])) {
			echo "Logged in as: " ;
			echo $_SESSION['username'] ;
			echo '<form name="input" action="/First.php" method="post">
		<input type="submit" name="logout" value="Log out">
		</form>';

		} else {
			echo '<a href="/login.php">Log in</a><br>' ;
			echo '<a href="/createAccount.php">Create Account</a>' ;
		 
		}
		echo '<br><br>' ;
		if(isset($_POST['logout'])) {
			if($_POST['logout']) {
				echo "logged out";
			}
		}
		?>
		<br>
		<br><a href="/First.php">Main page</a>
		</p>
		<p>Pencil. Amount: 
		<?php
		echo $_SESSION['pencil'];
		?>
		<br>
		Notebook. Amount:
		<?php
		echo $_SESSION['notebook'];
		echo "<br>";
				if (isset($_SESSION['username'])) {
			echo '<form name="input" action="/checkout.php" method="post">
		<input type="submit" name="checkout" value="Checkout">
		</form>';

		}
		?>
		</p>
		
	</body>
</html>
