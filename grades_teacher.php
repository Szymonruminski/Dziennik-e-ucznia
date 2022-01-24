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

	<title>Oceny uczniów</title>
</head>
<body>
    <?php 
    echo "<div class='container2'>";
    echo "<div id='menu'>";
    echo "<a href='teacher.php' title='Strona główna'>Strona główna</a>";
    echo "<a href='students_teacher.php' title='Uczniowie'>Uczniowie</a>";
    echo "<a href='grades_teacher.php' title='Oceny' class='active'>Oceny</a>";
    echo "<a href='plan_teacher.php' title='Plan lekcji'>Plan lekcji</a>";
    echo "<a href='frequency_teacher.php' title='Frekwencja'>Frekwencja</a>";
    echo "<a href='messages_teacher.php' title='Komunikaty'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br>";
	
	?>
<div id="frekall">	<p><h2>
	 <?php 
	include 'config.php';

  $zmienna = $_SESSION['username'];
  $sql = "SELECT przedmiot from teachers where username = '$zmienna'";
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane 
  while($row = $result->fetch_assoc()) {
    echo "Oceny z przedmiotu: " . $row["przedmiot"];
  }
} 


?>
</h2></p>




<?php 
include 'config.php';
if(isset($_POST['submit'])){
    $id_oceny =$_POST['id_grades'];
	$what = $_POST['whattodo'];
	$grade=$_POST['change_grade']; 
	$newgrade=$_POST['new_grade']; 
	$newid=$_POST['new_id']; 
	 $zmienna = $_SESSION['username'];
	$zapytanie = "SELECT przedmiot from teachers where przedmiot = (SELECT przedmiot from teachers where username = '$zmienna')  "; //
	$wynik = mysqli_query($db, $zapytanie);
	$przedmiot = $wynik->fetch_array()[0] ?? '';



	if($what==0){
     $sql = "DELETE FROM grades WHERE id_oceny = '$id_oceny'";
	$result = mysqli_query($db, $sql);
	$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania ocenami przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " usunął  ocene o ID: " . $id_oceny . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);}
 
		if($what==1 && $grade<=6 ){
			 $sql = "UPDATE grades SET ocena = '$grade' WHERE id_oceny = '$id_oceny'";
		$result = mysqli_query($db, $sql);
$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania ocenami przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " zmienił  ocene o ID: " . $id_oceny . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);}
		
		if($what==2 && $newgrade<=6 ){
			
		 $sql = "INSERT INTO `grades` (`id_oceny`, `przedmiot`, `ocena`, `id_ucznia`) VALUES (NULL, '$przedmiot', '$newgrade', '$newid')";
		$result = mysqli_query($db, $sql);
		$myfile = fopen("log.txt", "a") or die("Unable to open file!");
					$txt = "-----Log odnośnie strony zarządzania ocenami przez nauczyciela-----\n";
					fwrite($myfile, $txt);
					 $today = date("Y-m-d H:i");
					$txt = $today . " Nuczyciel: " . $_SESSION['username'] . " dodał nową ocene o ID: " . $id_oceny . "\n"; 
					fwrite($myfile, $txt);
					fclose($myfile);}
		
		

	
		
		
		

 
}
?>






<table class="blueTable">

 <?php 
 
   $zmienna = $_SESSION['username'];
$sql = "SELECT id_oceny,imie,nazwisko,przedmiot,ocena FROM students natural join grades where przedmiot = (SELECT przedmiot from teachers where username = '$zmienna')  "; //
 $result = $db->query($sql);


echo "
<thead>
<tr>
<th>ID oceny</th>
<th>Imię</th>
<th>Nazwisko</th>
<th>przedmiot</th>
<th>ocena</th>
</tr>";


if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {  
echo "<tbody><tr><td>" . $row['id_oceny'] . "</td>  <td>" . $row['imie'] . "</td>  <td>" . $row['nazwisko'] . "</td>  <td>" . $row['przedmiot'] . "</td>  <td>" . $row['ocena'] .  "</td>  </tr></tbody>";  
}}

?>
</table>

<div id="hide">

  <p> Wybierz id_oceny </p>
<form action="" method="POST">
     <select name="id_grades">
 <?php 
// wyświetlenie przedmiotu którego uczy zalogowany nauczyciel
$sql = "SELECT id_oceny FROM students natural join grades where przedmiot = (SELECT przedmiot from teachers where username = '$zmienna')  "; //
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  
	
  while($row = $result->fetch_assoc()) {

echo "<option value='".$row['id_oceny']."'>".$row['id_oceny']."</option>"; 
}}
?>

</select>
</div>
  <p> Wybierz czynność </p>

<select id="test" name="whattodo" onchange="showDiv('hidden_div', this);showDiv2('hidden_div2', this)">
   <option value="0"> usuń </option>
   <option value="1"> zmień </option>
   <option value="2"> dodaj </option>
   
</select>
<div id="hidden_div">
   <p>Wybierz na jaką ocene zmienić </p>
   <select id="test" name="change_grade">
    <option value="1"> 1 </option>
   <option value="2"> 2 </option>
   <option value="3"> 3 </option>
   <option value="4"> 4 </option>
   <option value="5"> 5 </option>
   <option value="6"> 6 </option>
 </select>

</div>
<div id="hidden_div2">

   <p>Wybierz jaką ocene dodać </p>
   <select id="test" name="new_grade">
    <option value="1"> 1 </option>
   <option value="2"> 2 </option>
   <option value="3"> 3 </option>
   <option value="4"> 4 </option>
   <option value="5"> 5 </option>
   <option value="6"> 6 </option>
 </select>
     <p> Wybierz ucznia </p>
   <select id="test" name="new_id">
<?php
$sql = "SELECT id_ucznia, nazwisko FROM students "; 
  $result = $db->query($sql);

if ($result->num_rows > 0) {
  
	
  while($row = $result->fetch_assoc()) {

echo "<option value='".$row['id_ucznia']."'>".$row['nazwisko']."</option>"; 
}}
?>
</select>



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