<!DOCTYPE html>


<header>
<link rel="stylesheet" href="CSS.PhotoVue.css">
<header/>
<?php $Username="Jérémie Lacroix"; 
		$connecter=true;
		$login_link="#login";
		
?>

<body>

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


<Post>
<div class="photolist">
	<div class='photo'>
		<table>
			<tr>
				<td><a href='#User' style='padding:10px;'>$Username</a></tb>	
			</tr>
			<tr>
				<td><img src='images/allo.jpg'></tb>	
			</tr>
		</table>
	</div>

	<input type ="text"><input type="Submit" value="Commenter">

	<br>
</div>
</Post>