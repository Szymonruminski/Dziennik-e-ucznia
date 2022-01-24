<?php 
error_reporting(E_ALL ^ E_NOTICE);

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
    echo "<a href='frequency.php' title='Frekwencja'>Frekwencja</a>";
    echo "<a href='messages.php' title='Komunikaty' class='active'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br><br>";
		include 'config.php';
?>	<?php 
include 'config.php';
if(isset($_POST['submitt'])){
    $id_nauczyciela =$_POST['names'];
    $mess_t =$_POST['mess'];
	$today = date("Y-m-d");
	$zmienna = $_SESSION['username'];
	$zapytanie = "SELECT nazwisko from users where username = '$zmienna'"; //zapytanie o nazwisko zalogowanej osoby
	$wynik = mysqli_query($db, $zapytanie);
	$nazwisko_rodzica = $wynik->fetch_array()[0] ?? ''; // przypisanie nazwiska zalogowanej osoby do zmiennej $nazwisko_rodzica
	$zapytanie2 = "SELECT id_rodzica from users where username = '$zmienna'";
	$wynik2 = mysqli_query($db, $zapytanie2);
	$id_rodzica = $wynik2->fetch_array()[0] ?? ''; // przypisanie id zalogowanej osoby do zmiennej $id_rodzica
    $zapytanie3 = "SELECT nazwisko_t from teachers where id_nauczyciela = '$id_nauczyciela'";
	$wynik3 = mysqli_query($db, $zapytanie3);
	$nazwisko_nauczyciela = $wynik3->fetch_array()[0] ?? '';
 $sql = "INSERT INTO `messages` (`id_wiadomosci`, `id_rodzica`, `nazwisko_r`, `id_nauczyciela`, `nazwisko_t`, `wiadomosc_t`, `wiadomosc_r`, `data_wyslania`) VALUES (NULL, '$id_rodzica','$nazwisko_rodzica' ,'$id_nauczyciela', '$nazwisko_nauczyciela', '', '$mess_t', '$today')";
 $result = mysqli_query($db, $sql);
 $myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony do wysyłania wiadomości dla rodziców-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " Wysłał wiadomość do nauczyciela o ID: " . $id_nauczyciela . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
}

echo "<div id='menu2'>";
echo "<a href='messages.php' title='Wiadomosci'>Wiadomości</a>";
echo "<a href='newmessage.php' title='Napisz wiadomość' class='active'>Napisz wiadomość</a>";
echo "</div>";
echo "<br><br>";

?>
<div id="frekall"><p><h2>Nowa wiadomość: </h2></p>
<p> Wybierz nauczyciela do którego chcesz napisać: </p>
    
<form action="" method="POST" id="form1">
     <select name="names">
	

	<?php

  echo "<br>";
 $sql = "SELECT username,id_nauczyciela,nazwisko_t from teachers";
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane 
	
  while($row = $result->fetch_assoc()) {

echo "<option value='".$row['id_nauczyciela']."'>".$row['username']." ".$row['nazwisko_t']."</option>"; 
  } 

} 

?>
   </select><br><br>
    <p> Treść wiadomości</p>
<textarea name="mess" style="width: 500px" 	required  placeholder='Tutaj wpisz treść wiadomości' rows="4"></textarea>
<br><br>
<button name="submitt" class="button-34" form="form1">Wyślij</button>  
<br><br>
  

<br>
<table class="blueTablemes"> <?php 
if(isset($_POST['submit'])){
$today = date("Y-m-d");
    $id_nauczycielaa =$_POST['namess'];
 $zmienna = $_SESSION['username'];
 $zapytaniex = "SELECT username from teachers where id_nauczyciela = '$id_nauczycielaa'"; 
	$wynikx = mysqli_query($db, $zapytaniex);
	$imie_rodzicaa = $wynikx->fetch_array()[0] ?? '';
$sql = "SELECT `wiadomosc_r`,`wiadomosc_t` FROM `messages` WHERE id_nauczyciela = '$id_nauczycielaa' and id_rodzica =  (SELECT id_rodzica from users where username = '$zmienna')  "; //";";
 $result = $db->query($sql);
</form>
}

if(!empty($imie_rodzicaa))
{
echo "
<thead>
<tr>
<th>Nauczyciel($imie_rodzicaa)</th>
<th>Ja(" . $_SESSION['username'] . ")</th>

</tr>";
}

if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {  
echo "<tbody><tr><td>"."<h2>" . $row['wiadomosc_t']  ."</h2>". "</td>  <td>" . "<h2>". $row['wiadomosc_r'] . "</h2>" . "</td>  </tr></tbody>";   
}}


echo "</table>";
?>
 <?php 
echo "<br><br><br>";
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