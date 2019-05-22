<!DOCTYPE html>
<?php
session_start();
?>
<?php

			$Erreur = "";
			try {
					
					$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
					
					
					echo 'En ligne';
			} catch (PDOException $e) {
					print "Erreur !: " . $e->getMessage() . "<br/>";
					die();
			}
	?>
	

<header>
<link rel="stylesheet" href="CSS.Photo.css">
<header/>
<?php 	$_SESSION['username'] = 'allo';
		$Username=$_SESSION['username']; 
		$connecter=true;	
?>

<body style="background-color:black;">

<navigation>
<div class="topnav">
  <a class="active" href="#home">Home</a>
  <a href="#about">About</a>
  
  <a style="float:right;" href="#logout">
<?php
	if($connecter==true){
		echo "logout";
	}
  ?> </a>
  <?php
	if($connecter==false)
		echo "<a style='float:right;' href='#login'> Login </a>";
	else
		echo "<a style='float:right;' href='#Profil'> $Username </a>";
  ?>
</div>
</navigation>




<newsfeed>
<a href="#post">
<div style="text-align:center;padding:10px;">
Ajouter un post
</div>
</a>




<?php 

if($connecter==false){
	echo "you are offline please";
	echo	"<a href='#login'>login</a>";
	echo  "to see pictures";
}
else {
	
	$resultat = $Mybd->query("SELECT id FROM Images");
	echo "
<div class='column'>
  <div class='row'>
    <img src='images/1.jpg' alt='Nature' onclick='Afficher_img(this);' style='width:100px;height:100px;'>
  </div>
  <div class='row'>
    <img src='images/2.jpg' alt='Snow' onclick='Afficher_img(this);' style='width:100px;height:100px;'>
  </div>
  <div class='row'>
    <img src='images/3.jpg' alt='Mountains' onclick='Afficher_img(this);' style='width:100px;height:100px;'>
  </div>
  <div class='row'>
    <img src='images/4.jpg' alt='Lights' onclick='Afficher_img(this);' style='width:100px;height:100px;'>
  </div>
</div>


<div class='container'>
  <!-- Close the image -->
  <span onclick='this.parentElement.style.display='none'' class='closebtn'>&times;</span>

  <!-- Expanded image -->
  <img id='expandedImg' style='width:100%'>

  <!-- Image text -->
  <div id='imgtext'></div>
</div>";
	
}
?>




</newsfeed>


<body/>
<script>
function Afficher_img(imgs) {
  // Get the expanded image
  var expandImg = document.getElementById("expandedImg");
  // Get the image text
  var imgText = document.getElementById("imgtext");
  // Use the same src in the expanded image as the image being clicked on from the grid
  expandImg.src = imgs.src;
  // Use the value of the alt attribute of the clickable image as text inside the expanded image
  imgText.innerHTML = imgs.alt;
  // Show the container element (hidden with CSS)
  expandImg.parentElement.style.display = "block";
}
</script> 