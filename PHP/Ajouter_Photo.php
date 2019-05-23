<?php
session_start();
$_SESSION['username'] = "allo";
$allo = $_SESSION['username'];
$connecter =true;
?>

<?php

			$Erreur = "";
			try {

					$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));

			} catch (PDOException $e) {
					print "Erreur !: " . $e->getMessage() . "<br/>";
					die();
			}
	?>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		
	}
?>


<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="CSS.Ajouter_photo.css">
</header>
<body>

<navigation>
<div class="topnav">
  <a href="<Photo.php">Galerie Photo</a>
  <a href="Ajout.php">Ajouter une photo</a>
  <a style="float:right;" href="#logout">
  <?php
	if($connecter==true){
		echo "logout";
	}
  ?> </a>
  <?php
	if($connecter==false)
	{
		echo "<a style='float:right;' href='login.php'> Login </a>";
	}
	else
	{
	  echo "<a style='float:right;' href='#Profil'>$allo</a>";
	}
  ?>
</div>
</navigation>


<div class="container">
  <form action="action_page.php">
    <div class="row">
      <div class="col-25">
        <label for="Titre">Titre :</label>
      </div>
      <div class="col-75">
        <input type="text" id="Titre" name="firstname" placeholder="Le Titre de l'image...">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="URL">Url de l'image :</label>
      </div>
      <div class="col-75">
        <input type="text" id="URL" name="URL" placeholder="Url...">
      </div>
    </div>
     <div class="row">
      <div class="col-25">
        <label for="subject">Description de l'image :</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="subject" placeholder="Ex: fleur, oiseaux,etc." style="height:200px"></textarea>
      </div>
    </div>
	<div class="row">
	 <div class="col-25">
	 <label for="fichier image">Selectionner le fichier image :</label> 
	 </div>
	<div class="col-75">
      <input type="file" name="file">
    </div>
	
	</div>
    <div class="row">
      <input type="submit" value="Submit" onclick="Add_photo();">
    </div>
  </form>
</div> 






</body>



<script>
function Add_photo()
{
	<?php
	
	?>
	
}

</script>