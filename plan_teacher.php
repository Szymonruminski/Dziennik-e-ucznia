<?php include_once('functions.php'); ?>
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

	<title>Plan Lekcji</title>
</head>
<body>
    <?php 
    echo "<div class='container2'>";
    echo "<div id='menu'>";
    echo "<a href='teacher.php' title='Strona główna'>Strona główna</a>";
    echo "<a href='students_teacher.php' title='Uczniowie'>Uczniowie</a>";
    echo "<a href='grades_teacher.php' title='Oceny'>Oceny</a>";
    echo "<a href='plan_teacher.php' title='Plan lekcji' class='active'>Plan lekcji</a>";
    echo "<a href='frequency_teacher.php' title='Frekwencja'>Frekwencja</a>";
    echo "<a href='messages_teacher.php' title='Komunikaty'>Komunikaty</a>";
    echo "</div>";
    



    echo "<br><br>";
	include 'config.php';
  $sql = "SELECT przedmiot from teachers where id_nauczyciela = 1";



?>

<link type="text/css" rel="stylesheet" href="jscript/style.css"/>
<link type="text/css" rel="stylesheet" href="jscript/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="jscript/bootstrap/css/bootstrap.min.css"/>
<script src="jscript/jquery.min.js"></script>
<div id="calendar_div" class="container">

	<?php echo getCalender(); ?>
</div>


 <?php 

echo "<div id='stopka'>";
echo "<br><br><br>";

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