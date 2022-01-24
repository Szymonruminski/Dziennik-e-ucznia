<?php 
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
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

	<title>Frekwencja</title>
</head>
<body>
    <?php 
    echo "<div class='container2'>";
    echo "<div id='menu'>";
    echo "<a href='teacher.php' title='Strona główna'>Strona główna</a>";
    echo "<a href='students_teacher.php' title='Uczniowie'>Uczniowie</a>";
    echo "<a href='grades_teacher.php' title='Oceny'>Oceny</a>";
    echo "<a href='plan_teacher.php' title='Plan lekcji'>Plan lekcji</a>";
    echo "<a href='frequency_teacher.php' title='Frekwencja' class='active'>Frekwencja</a>";
    echo "<a href='messages_teacher.php' title='Komunikaty'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br>";
	include 'config.php';
?>
<div id="frekall">
<p><h2>Sprawdź frekwencję: </h2></p>

	





<?php 
include 'config.php';
if(isset($_POST['submit'])){
    $nazwisko =$_POST['names'];
	$today = date("Y-m-d");
	$time = $_POST['datavalue'];
	$checkbox1=$_POST['sprawdz']; 
	$chk="";
	foreach($checkbox1 as $chk1)  
   {  
      $chk .= $chk1;  
   }  
   	 if(!$chk == ''){
	
	 $zmienna = $_SESSION['username'];
  $zapytanie = "SELECT przedmiot from teachers where przedmiot = (SELECT przedmiot from teachers where username = '$zmienna')  "; //
	$wynik = mysqli_query($db, $zapytanie);
	$przedmiot = $wynik->fetch_array()[0] ?? '';
	  	$sql = "SELECT nazwisko,data,przedmiot FROM frekwencja where nazwisko='$nazwisko' and  data ='$time' and przedmiot = '$przedmiot' ";
 $result = mysqli_query($db, $sql);
	
			if (!$result->num_rows > 0) {
  
     $sql = "INSERT INTO `frekwencja` (`id_obecności`, `nazwisko`, `data`, `przedmiot`, `obecność`) VALUES (NULL, '$nazwisko', '$time','$przedmiot', '$chk')";
			$result = mysqli_query($db, $sql);
			echo "<h2>Pomyślnie dodano frekwencję</h2>";
			$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania Frekwencją przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " dodał frekwencję dla ucznia: " . $nazwisko . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);}
            else {
			echo "<script>alert('W tym dniu ten uczeń już miał sprawdzaną obecność.')</script>";}
			$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania Frekwencją przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " Próbował dodać frekwencję dla ucznia: " . $nazwisko . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);



 
} else {echo "<script>alert('Nie wybrałeś statusu, wybierz czy uczen jest: obecny, nieobecny czy spóźniony')</script>";}}
?>


  
 
 <br>
 <form action="" method="POST">

  
  <p> Wybierz ucznia w celu weryfikacji frekwencji</p>
<form action="" method="POST">
     <select name="names">
	

	<?php

  echo "<br>";
 $sql = "SELECT imie,nazwisko from students";
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane 
	
  while($row = $result->fetch_assoc()) {

echo "<option value='".$row['nazwisko']."'>".$row['nazwisko']."</option>"; 
  } 

} 

?>


   </select><br><br>
 
   <input type="checkbox" id="1" value="obecny"  name="sprawdz[]" onclick="getSelectItemThat(this.id)" /> Obecny
<input type="checkbox" id="2" value="nieobecny" name="sprawdz[]" onclick="getSelectItemThat(this.id)" /> Nieobecny
<input type="checkbox" id="3" value="spóźniony" name="sprawdz[]" onclick="getSelectItemThat(this.id)" /> Spóźniony <br><br>
  
   <p> wybierz datę </p>
<input type="date" id="datavalue" name="datavalue" value="<?php echo date('Y-m-d'); ?>" '>  <br><br>
<button name="submit" class="button-34">Srawdź obecność</button>  
  


  </form>  
  <br>
  
  
   <?php 
   
    $zmienna = $_SESSION['username'];
  $sql = "SELECT przedmiot from teachers where username = '$zmienna'";
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane 
  while($row = $result->fetch_assoc()) {
    echo "Uczniowie którym została sprawdzona dzisiaj obecność z przedmiotu: " . $row["przedmiot"];
  }
} ?>


   <?php 
   

	
		
	
   // $sql = "SELECT imie, nazwisko from students natural join frekwencja where data = '$today' ";
 

?><table class="blueTable"> <?php 
$today = date("Y-m-d");
 $zmienna = $_SESSION['username'];
$sql = "SELECT imie,nazwisko,przedmiot,data,obecność FROM students  natural join frekwencja where przedmiot = (SELECT przedmiot from teachers where username = '$zmienna') and data = '$today' "; 
 $result = $db->query($sql);


echo "
<thead>
<tr>
<th>Imię</th>
<th>Nazwisko</th>
<th>przedmiot</th>
<th>data</th>
<th>status</th>
</tr>";


if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {  
echo "<tbody><tr><td>" . $row['imie'] . "</td>  <td>" . $row['nazwisko'] . "</td>  <td>" . $row['przedmiot'] . "</td>  <td>" . $row['data'] . "</td>  <td>" . $row['obecność'] . "</td>  </tr></tbody>";   
}}


echo "</table>";
?>

<script>
function getSelectItemThat(id) {
    for (var i = 1;i <= 3; i++)
    {
        document.getElementById(i).checked = false;
    }
    document.getElementById(id).checked = true;
}
</script>
<br>

</div>

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