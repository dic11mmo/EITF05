<!DOCTYPE html>
<?php
	session_start();
	$inputIsValid = true;
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
	if(!isset($_SESSION['pencil'])) {
		$_SESSION['pencil'] = 0;
	}
	
	if(isset($_POST['cardNumber'])) {
		if(preg_match("/[0-9]{16}/", $_POST['cardNumber'])) {
		} else {
			$inputIsValid = false;
		}
	} else {
		$inputIsValid = false;
	}
	if(isset($_POST['month'])) {
		if(preg_match("/(0[1-9]|1[0-2])/", $_POST['month'])) {
		} else {
			$inputIsValid = false;
		}
	} else {
		$inputIsValid = false;
	}
	if(isset($_POST['year'])) {
		if(preg_match("/[0-9]{2}/", $_POST['year'])) {
		} else {
			$inputIsValid = false;
		}
	} else {
		$inputIsValid = false;
	}
	if(isset($_POST['cvccvv'])) {
		if(preg_match("/[0-9]{3}/", $_POST['cvccvv'])) {
		} else {
			$inputIsValid = false;
		}
	} else {
		$inputIsValid = false;
	}
	$correctPassword = false;
	if (isset($_SESSION['username']) and isset($_POST['pwd'])) {
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
		mysqli_stmt_bind_param($stmt, 'ss', $_SESSION['username'], hash('sha256', $_POST['pwd']));
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $u_address, $u_pass, $u_name);
		mysqli_stmt_fetch($stmt);
		if($u_name) {
			$correctPassword = true;
		}
	}
?>
<html>
	<head>
		<title>Receipt</title>
	</head>
	<body>
		<h1> Receipt </h1>
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
				if ($inputIsValid and $correctPassword) {
					$total = $_SESSION['pencil'] * 8 + $_SESSION['notebook'] * 14;
					echo 'Total price: '.$total.' SEK.</br>';
					echo "Pencil. Amount: ".$_SESSION['pencil'];
					echo "</br>Notebook. Amount: ".$_SESSION['notebook'].'</br>';
					echo "Card Number: ";
					echo $_POST['cardNumber'].'</br>';
					$objDateTime = new DateTime('now');
					echo "Date and time: ".$objDateTime->format("Y-m-d\TH:i:sP");
				} else {
					echo "Invalid user input or wrong password. Purchase cancelled.";
				}
			} else {
				echo '<a href="/login.php">Log in</a><br>' ;
				echo '<a href="/createAccount.php">Create Account</a>' ;
			}
			echo '<br><br><a href="/First.php">Main page</a><br>' ;
		?>
		<br>
		</p>
		
	</body>
</html>
