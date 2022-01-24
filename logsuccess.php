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
    echo "<a href='logsuccess.php' title='Strona główna' class='active'>Strona główna</a>";
    echo "<a href='grades.php' title='Oceny'>Oceny</a>";
    echo "<a href='plan.php' title='Plan lekcji'>Plan lekcji</a>";
    echo "<a href='frequency.php' title='Frekwencja'>Frekwencja</a>";
    echo "<a href='messages.php' title='Komunikaty'>Komunikaty</a>";
    echo "</div>";
    
    echo "<br><br>";
    echo "<h1>Witaj " . $_SESSION['username'] .   "</h1>"; // wyświetlenie imienia rodzica
		include 'config.php';
		$username = $_SESSION['username'];
$sql = "SELECT imie, nazwisko from students where pesel = (SELECT pesel from users where username = '$username')";
$result = $db->query($sql);

if ($result->num_rows > 0) {
  // wyświetla dane ucznia którego rodzicem jest obecnie zalogowany użytkownik
  while($row = $result->fetch_assoc()) {
    echo "Twoje dziecko to: " . $row["imie"], " " . $row["nazwisko"];
  }
} 
$db->close();
?>

<br><br><br>
<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="img1.png" style="width:100%">
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="img2.png" style="width:100%">
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="img3.png" style="width:100%">
</div>

<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" actives", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " actives";
}
</script>





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