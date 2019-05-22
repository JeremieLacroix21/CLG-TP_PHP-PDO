<!DOCTYPE html>


<header>
<link rel="stylesheet" href="CSS.Photo.css">
<header/>
<?php $Username="Jérémie Lacroix"; 
		$connecter=true;
		$login_link="#login";
		
?>

<body style="background-color:black;">

<navigation>
<div class="topnav">
  <a class="active" href="#home">Home</a>
  <a href="#about">About</a>
  
  <a style="float:right;" href="#logout"><?php
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
<div class="photolist" style="text-align:center;padding:10px;">
Ajouter un post
</div>
</a>


<div class="photolist">

<?php 
if($connecter==false){
	echo "you are offline please";
	echo	"<a href='#login'>login</a>";
	echo  "to see pictures";
}
else {
	echo "	
			<img src='images/allo.jpg' style='width:665px; padding:10px;padding-left:10px;'></tb>";
	
}
?>



</div>
</newsfeed>


<body/>
