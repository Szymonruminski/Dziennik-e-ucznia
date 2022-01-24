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

	<title>Lista uczniów</title>
</head>
<body>
    <?php 
    echo "<div class='container2'>";
    echo "<div id='menu'>";
    echo "<a href='teacher.php' title='Strona główna'>Strona główna</a>";
    echo "<a href='students_teacher.php' title='Uczniowie' class='active'>Uczniowie</a>";
    echo "<a href='grades_teacher.php' title='Oceny'>Oceny</a>";
    echo "<a href='plan_teacher.php' title='Plan lekcji'>Plan lekcji</a>";
    echo "<a href='frequency_teacher.php' title='Frekwencja'>Frekwencja</a>";
    echo "<a href='messages_teacher.php' title='Komunikaty'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br>";
	include 'config.php';
?>

<?php 
include 'config.php';
if(isset($_POST['submit'])){
    $id_ucznia =$_POST['id_ucznia'];
	$what = $_POST['whattodo'];
	$changename=$_POST['change_name']; 
	$changesurname=$_POST['change_surname']; 
	$newname=$_POST['new_name']; 
	$newsurname=$_POST['new_surname']; 
	$pesel=$_POST['new_pesel']; 
	$changepesel=$_POST['change_pesel']; 
	

  
	if($what==0){
     $sql = "DELETE FROM students WHERE id_ucznia = '$id_ucznia'";
	$result = mysqli_query($db, $sql);
	$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania uczniami przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " usunął  ucznia o ID: " . $id_ucznia . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
	}
 
  if($what==1 && strlen($changepesel)==11){
		
			 $sql = "UPDATE students SET imie = '$changename', nazwisko = '$changesurname', pesel = '$changepesel' WHERE id_ucznia = '$id_ucznia'";
		$result = mysqli_query($db, $sql);
			$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania uczniami przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " zmienił dane ucznia o ID: " . $id_ucznia . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
		}
		if($what==2 && strlen($pesel)==11){
			
		 $sql = "INSERT INTO `students` (`id_ucznia`, `imie`, `nazwisko`, `pesel`) VALUES (NULL, '$newname', '$newsurname', '$pesel')";
		$result = mysqli_query($db, $sql);
		$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania uczniami przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " dodał nowego ucznia \n"; 
					fwrite($myfile, $txt);
					fclose($myfile);
		}
		


 

}

  
?><div id="frekall"><p><h2>Lista uczniów: </h2></p><table class="blueTable"> <?php 

$sql = "SELECT imie,nazwisko,id_ucznia,pesel FROM students  ";
 $result = $db->query($sql);


echo "
<thead>
<tr>
<th>Imię</th>
<th>Nazwisko</th>
<th>Id_ucznia</th>
<th>Pesel ucznia</th>
</tr>";


if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {  
echo "<tbody><tr><td>" . $row['imie'] . "</td>  <td>" . $row['nazwisko'] . "</td>  <td>" . $row['id_ucznia'] . "</td>  <td>" . $row['pesel'] . "</td>  </tr></tbody>";   
}}


echo "</table>";
?>

  <p> Wybierz id_ucznia </p>
<form action="" method="POST">
     <select name="id_ucznia">
 <?php 

$sql = "SELECT id_ucznia FROM students"; 
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  
	
  while($row = $result->fetch_assoc()) {

echo "<option value='".$row['id_ucznia']."'>".$row['id_ucznia']."</option>"; 
}}
?>

</select>

  <p> Wybierz czynność </p>

<select id="test" name="whattodo" onchange="showDiv('hidden_div', this);showDiv2('hidden_div2', this)">
   <option value="0"> usuń </option>
   <option value="1"> zmień </option>
   <option value="2"> dodaj </option>
   
</select>
<div id="hidden_div">
   <p> Wprawdź dane do zmiany </p>
 <p> imię </p>
  <input type="text" id="fname" name="change_name" placeholder="imię" size="10%" >
 <p> nazwisko </p>
  <input type="text" id="fname" name="change_surname" placeholder="nazwisko" size="10%" >
 <p> pesel </p>
  <input type="text" id="fname" name="change_pesel" placeholder="pesel" size="10%" >
  <h6>Pesel musi zawierać 11 liczb.<h6>
</div>
<div id="hidden_div2">
 <p> Wprawdź dane w celu dodania ucznia </p>
   <p>  nowe imię </p>
  <input type="text" id="fname" name="new_name" placeholder="imię" size="10%" >
     <p>  nowe nazwisko</p>
  <input type="text" id="fname" name="new_surname" placeholder="nazwisko" size="10%" >
  <p>  nowe pesel</p>
  <input type="text" id="fname" name="new_pesel" placeholder="pesel" size="10%" ><br>
<h6>Pesel musi zawierać 11 liczb.<h6>
</div>
<p> </p> <br>
<button name="submit" class="button-34">Wykonaj</button>  
</form>
<script>
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';

}
</script>

<script>
function showDiv2(divId, element)
{
    document.getElementById(divId).style.display = element.value == 2 ? 'block' : 'none';

}
</script>
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