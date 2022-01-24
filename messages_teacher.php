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

	<title>Komunikaty</title>
</head>
<body>

    <?php 
    echo "<div class='container2'>";
    echo "<div id='menu'>";
    echo "<a href='teacher.php' title='Strona główna'>Strona główna</a>";
    echo "<a href='students_teacher.php' title='Uczniowie'>Uczniowie</a>";
    echo "<a href='grades_teacher.php' title='Oceny'>Oceny</a>";
    echo "<a href='plan_teacher.php' title='Plan lekcji'>Plan lekcji</a>";
    echo "<a href='frequency_teacher.php' title='Frekwencja'>Frekwencja</a>";
    echo "<a href='messages_teacher.php' title='Komunikaty' class='active'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br>";
	include 'config.php';
 
?>

<?php 
include 'config.php';


echo "<div id='menu2'>";
    echo "<a href='messages_teacher.php' title='Wiadomosci' class='active'>Wiadomości</a>";
    echo "<a href='newmessage_teacher.php' title='Napisz wiadomość'>Napisz wiadomość</a>";
echo "</div>";
echo "<br><br>";

?>
<div id="frekall">
<p><h2> Wyświetl rozmowy z rodzicem:</h2></p>	
 
</form><form action="" method="POST" id="form2" >
     <select name="namess">
	 <option="selected" >
wybierz
</option>
    <?php

  echo "<br>";
 $sql = "SELECT username,id_rodzica,nazwisko from users";
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane 
	
  while($row = $result->fetch_assoc()) {

echo "<option value='".$row['id_rodzica']."'>".$row['username']." ".$row['nazwisko']."</option>"; 
  } 

} 

?>

</select>
  <input type="submit" name="submit" value='Zobacz wiadomości'>
</form>

<br>
<table class="blueTablemes"> <?php 
if(isset($_POST['submit'])){
$today = date("Y-m-d");
    $id_rodzicaa =$_POST['namess'];
 $zmienna = $_SESSION['username'];
 $zapytaniex = "SELECT username from users where id_rodzica = '$id_rodzicaa'"; 
	$wynikx = mysqli_query($db, $zapytaniex);
	$imie_rodzicaa = $wynikx->fetch_array()[0] ?? '';
	 $zapytaniex2 = "SELECT id_nauczyciela from teachers where user = '$id_rodzicaa'"; 
	$wynikx = mysqli_query($db, $zapytaniex);
	$imie_rodzicaa = $wynikx->fetch_array()[0] ?? '';
$sql = "SELECT `wiadomosc_r`,`wiadomosc_t`,`data_wyslania` FROM `messages` WHERE id_rodzica = '$id_rodzicaa' and id_nauczyciela = (SELECT id_nauczyciela from teachers where username = '$zmienna')  "; //";
 $result = $db->query($sql);

}

if(!empty($imie_rodzicaa))
{
echo "
<thead>
<tr>
<th>Ja(" . $_SESSION['username'] . ")</th>
<th>Rodzic($imie_rodzicaa)</th>
</tr>";
}

if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {  
//echo "<tbody><tr><td>"."<h2><div class='messages'>" . $row['wiadomosc_t']  ."</div></h2>". "</td>  <td>" . "<h2><div class='messages darker'>". $row['wiadomosc_r'] . "</div></h2>" . "</td>  </tr></tbody>";   
echo "<tbody><tr><td>";
if($row['wiadomosc_t'] != null)
{
  echo "<div class='messages darker'>" ."<span class='date-left'>".$row['data_wyslania']."</span><br><h2>". $row['wiadomosc_t']  ."</div></h2>";
} else echo "";
echo "</td>  <td>";
if($row['wiadomosc_r'] != null)
{
  echo "<div class='messages'>" ."<span class='date-right'>".$row['data_wyslania']."</span><br><h2>". $row['wiadomosc_r']. "</div></h2>";
} else echo "";
echo "</td>  </tr></tbody>";

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