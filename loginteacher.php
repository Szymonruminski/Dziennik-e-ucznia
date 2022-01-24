<?php 

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
    	header("Location: logsuccess.php");
}

if (isset($_POST['submit'])) {
	$login = $_POST['login'];
	$password = md5($_POST['password']);

	$sql = "SELECT * FROM teachers WHERE login='$login' AND password='$password'";
	$result = mysqli_query($db, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
		$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony logowania nauczyciela-----\n";
			
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Zalogowanie na konto e-mailem: " . $login . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
		
		header("Location: teacher.php");}
		
	 else {
		echo "<script>alert('Login lub hasło jest niepoprawne.')</script>";
			$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony logowania-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Użytkownik wprowadził złe hasło, próba logowania z e-mailem: " . $login . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Logowanie</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Logowanie</p><br>
				<p class="login-text" style="font-size: 1rem; font-weight: 200;">Konto Nauczyciela</p>
		
			<div class="input-group">
				<input type="login" placeholder="Login" name="login" value="<?php echo $login; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Hasło" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">

				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Jesteś rodzicem? <a href="index.php">Zaloguj się tutaj</a>.</p>
			<p class="login-register-text">Nie masz konta? <a href="register.php">Zarejestruj się tutaj</a>.</p>
		</form>
	</div>
</body>
</html>