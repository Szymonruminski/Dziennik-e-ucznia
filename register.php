<?php 

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['email'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	$pesel =$_POST['pesel'];

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		$sqlpesel = "SELECT * FROM students where pesel='$pesel'"; 
	
		
		$result = mysqli_query($db, $sql);
		$check_pesel_exist = mysqli_query($db, $sqlpesel);
	
			if($check_pesel_exist -> num_rows > 0){
				
				
			if (!$result->num_rows > 0) {
				$sql = "INSERT INTO users (username, nazwisko, email, password, pesel)
						VALUES ('$username','$surname', '$email', '$password', '$pesel')";
		
				$result = mysqli_query($db, $sql);
				if ($result) {
					echo "<script>alert('Rejestracja przebiegła pomyślnie.')</script>";
					$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony rejestracji-----\n";
			
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Zarejestrowano konto pomyślnie z e-mailem: " . $email . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
					
					$username = "";
					$email = "";
					$surname = "";
					$pesel = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";
				} else {
					echo "<script>alert('Coś poszło nie tak.')</script>";
				}
			} else {
				echo "<script>alert(Taki E-mail już istnieje.')</script>";
			}
			
		
		} else {
			echo "<script>alert('Podany pesel jest błędny.')</script>";
		}
	}else {
			echo "<script>alert('Hasła nie pasują do siebie.')</script>";
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

	<title>Rejestracja</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Rejestracja</p>
			<div class="input-group">
				<input type="text" placeholder="Imię" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Nazwisko" name="surname" value="<?php echo $surname; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			
			<div class="input-group">
				<input type="password" placeholder="Hasło" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Potwierdź hasło" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
			<input type="pesel" placeholder="Pesel ucznia" name="pesel" value="<?php echo $_POST['pesel']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Zarejestruj</button>
			</div>
			<p class="login-register-text">Masz już konto? <a href="index.php">Zaloguj się tutaj</a>.</p>
		</form>
	</div>
</body>
</html>