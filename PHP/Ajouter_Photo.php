<?php
session_start();
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




<!DOCTYPE html>
<html>
<header>
<title>Galerie d'image/Ajout de photo</title>
<link rel="stylesheet" type="text/css" href="CSS.Ajouter_Photo.css">
</header>
<?php
if (isset($_SESSION['username']))
{
	$connecter=true;
}
else {
	$connecter=false;
}
if ($connecter)
{
	$stm = $Mybd->prepare("CALL VerifierAdmin(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
	$Username=$_SESSION['username'];
	$stm->bindParam(1, $Username);
	$stm->execute();
	$donnees = $stm->fetch();
	if($donnees[0] === 'Y')
	{
		$admin = 1;
	}
	else {
		$admin = 0;
	}
}
if (!isset($admin)) {
    $admin = 0;
}
$stm = $Mybd->prepare("CALL SelectNomPrenom(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
$stm->bindParam(1, $Username);
$stm->execute();
$donnees = $stm->fetch();
$Nom = $donnees[0];
$Prenom = $donnees[1];
?>

<body>
<navigation>
<div class="topnav">
  <a href="index.php">Galerie Photo</a>
	<?php
	if($admin == 1){
		echo ("<a href='admin.php'>Admin</a>");
	}
	if($connecter==true){
		echo "<a href='ajouter_Photo.php'>Ajouter une photo</a>";
		echo "logout";
		echo "<a style='float:right;' href='?logout=true'> logout</a>";
		if(isset($_GET['logout']))
		{
			setcookie("User", null , -1);
			session_start();
	    session_unset();
			header("location:index.php");
			$_SESSION['logout'] = "set";
		}
echo "<a style='float:right;' href='profil.php?reussi=0'> $Prenom $Nom  </a>";
	}
	else
	{
		echo "<a style='float:right;' href='login.php'> Login </a>";
	}
  ?>
</div>
</navigation>


<div class="container">
  <form method="post" action="upload.php" enctype="multipart/form-data">
    <div class="row">
      <div class="col-25">
        <label for="Titre">Titre :</label>
      </div>
      <div class="col-75">
        <input type="text"  name="Titre" placeholder="Le Titre de l'image..." required>
      </div>
    </div>
     <div class="row">
      <div class="col-25">
        <label for="Description">Description de l'image :</label>
      </div>
       <div class="col-75">
         <textarea  name="Description" placeholder="Ex: fleur, oiseaux,etc." style="height:200px" required></textarea>
       </div>
     </div>
	<div class="row">
	 <div class="col-25">
	 <label for="fichier image">Selectionner le fichier image :</label>
	 </div>
	<div class="col-75">
       <input name="fileToUpload"  size="35" type="file" accept=".jpg,.jpeg,.png,.gif" required>
    </div>
	</div>
	<div class="row">
      <input type="submit" value="Submit">
    </div>
	<?php
			if ($_SERVER['REQUEST_METHOD'] == "POST"){
			$_SESSION['idimage'] = 9;
			$_SESSION['Titre'] = $_POST['Titre'];
			$_SESSION['Description'] =  $_POST['Description'];
  }
	?>
  </form>
</div>

</body>
<footer>
<p style="text-align:center;">
site faite par Charles Bourgeois, Jérémie Lacroix, et Mathieu Sévignye -- 2019 -- TP FINALE PDO 
</p>
</footer>
</html>