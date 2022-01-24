<?php 


session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

  

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Witaj</title>
</head>
<body>
    <?php 
    echo "<div class='container2'>";
    echo "<div id='menu'>";
    echo "<a href='logsuccess.php' title='Strona główna'>Strona główna</a>";
    echo "<a href='grades.php' title='Oceny'>Oceny</a>";
    echo "<a href='plan.php' title='Plan lekcji'>Plan lekcji</a>";
    echo "<a href='frequency.php' title='Frekwencja' class='active'>Frekwencja</a>";
    echo "<a href='messages.php' title='Komunikaty'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br><br><br>";
		include 'config.php';
		$username = $_SESSION['username'];
    $sql = "SELECT imie, nazwisko from students where pesel = (SELECT pesel from users where username = '$username')";
    $result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane ucznia którego rodzicem jest obecnie zalogowany użytkownik i oceny
  while($row = $result->fetch_assoc()) {
    echo "<h2>Frekwencja dziecka:<br> ". "" . $row["imie"], " " . $row["nazwisko"] ."</h2>" ."";
  }
} 
$db->close();

?><br>
<p> Frekwencja ucznia z ostanich 7 dni.</p>
<?php

   

	
		
	

 

?><table class="blueTable"> <?php 
 include 'config.php';
 $sevendays = date('Y-m-d', strtotime('-7 days'));
$today = date("Y-m-d");
    $zmienna = $_SESSION['username'];
	// poniżej zapytanie na wybranie ostatnich 7 dni
$sql = "SELECT obecność,data,imie,nazwisko,przedmiot FROM students natural join frekwencja  where pesel = (SELECT pesel from users where username = '$zmienna') and data BETWEEN '$sevendays' and '$today'  "; //
 $result = $db->query($sql);


echo "
<thead>
<tr>
<th>data</th>
<th>Imię</th>
<th>Nazwisko</th>
<th>przedmiot</th>
<th>obecność</th>
</tr>";


if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {  
echo "<tbody><tr><td>" . $row['data'] . "</td>  <td>" . $row['imie'] . "</td>  <td>" . $row['nazwisko'] . "</td>  <td>" . $row['przedmiot'] . "</td>  <td>" . $row['obecność'] .  "</td>  </tr></tbody>";  
}}


?>
<?php
echo "<br>";
echo "<div id='stopka'>";

?>
<form action="logout.php">
    <input type="submit"  class="button-34" value="wyloguj" />
</form>
<?php
echo "</div>";
echo "</div>";

	?>

</body>
</html>