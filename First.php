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
		session_destroy();
		session_start();
	}
	
	if(isset($_POST['logout'])) {
		if($_POST['logout']) {
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
				);
			}
			session_destroy();
		}
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
	
	if(isset($_POST['pencil'])) {
		$_SESSION['pencil']++;
		unset($_POST['pencil']);
	}
	
	if(!isset($_SESSION['notebook'])) {
		$_SESSION['notebook'] = 0;
	}
	
	if(isset($_POST['notebook'])) {
		$_SESSION['notebook']++;
		unset($_POST['notebook']);
	}
?>
<html>
	<head>
		<title>Web shop</title>
	</head>
	<body>
		<?php
			if(isset($_POST['logout'])) {
			if($_POST['logout']) {
				echo "logged out";
			}
		}
		?>
		<h1> Web Shop </h1>
		<br>
		<p>
		<?php
	echo '<br><br>' ;
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
		?>
		<br>
				<form name="input" action="/First.php" method="post">
		 Pencil. 8 SEK<input type="submit" name="pencil" value="Add to cart">
		</form>
				<br>
				<form name="input" action="/First.php" method="post">
		 Notebook. 14 SEK<input type="submit" name="notebook" value="Add to cart">
		</form>
		<br>
		<a href="/cart.php">Shopping cart</a>
		</p>
	</body>
</html>
