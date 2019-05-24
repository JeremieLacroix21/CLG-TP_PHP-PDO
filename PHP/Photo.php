<!DOCTYPE html>
<?php
session_start();

			$Erreur = "";
			try {

					$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
			} catch (PDOException $e) {
					print "Erreur !: " . $e->getMessage() . "<br/>";
					die();
			}
?>

<header>
<link rel="stylesheet" href="CSS.Photo.css">
<header/>

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
  <a href="Photo.php">Galerie Photo</a>
	<?php
	if($admin == 1){
		echo ("<a href='Admin.php'>Admin</a>");
	}
	if($connecter==true){
		echo "<a href='Ajouter_Photo.php'>Ajouter une photo</a>";
		echo "logout";
		echo "<a style='float:right;' href='?logout=true'> logout</a>";
		if(isset($_GET['logout']))
		{
			session_start();
	    session_unset();
	    header("Location: login.php");
		}
		echo "<a style='float:right;' href='Profil.php?reussi=0'> $Prenom $Nom  </a>";
	}
	else
	{
		echo "<a style='float:right;' href='login.php'> Login </a>";
	}
  ?>
</div>
</navigation>

<table>
	<tr>
	<?php
		$stml = $Mybd->prepare("CALL NombreCommentaire(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
		$commentaire = $donnees[0];
		$stml->bindParam(1, $commentaire);
		$stml->execute();
		while ($comment = $stml->fetch())
		{
			$Nbcommentaires = $comment[0];
		}
		$nombrecolonne = 0;
		$stm = $Mybd->prepare("CALL GetImages()", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
		$stm->execute();
		while ($donnees = $stm->fetch())
		{
			$stml = $Mybd->prepare("CALL NombreCommentaire(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
			$commentaire = $donnees[0];
			$stml->bindParam(1, $commentaire);
			$stml->execute();
			while ($comment = $stml->fetch())
			{
				$Nbcommentaires = $comment[0];
			}
			if($nombrecolonne == 6) //fin de tr
			{
				echo '</tr><tr><td><a href = "PhotoVue.php?id="' . $donnees[0] . '"><img src="' . $donnees[3] . '"></a><div class = "Info">Titre:'
				. $donnees[1] . '</br> Description:' . $donnees[2] . '</br> Pseudonyme:' . $donnees[4] . '</br> Date:' . $donnees[5] . '</br>
				Nombres de commentaires:' .  $Nbcommentaires . '</br></div></td>';
				$nombrecolonne = 0;
			}
			else {
				echo '<td><a href = "PhotoVue.php?id=' . $donnees[0]. '"><img src="' . $donnees[3] . '"></a><div class = "Info">Titre:'
				. $donnees[1] . '</br> Description:' . $donnees[2] . '</br> Pseudonyme:' . $donnees[4] . '</br> Date:' . $donnees[5] . '</br>
				Nombres de commentaires:' .  $Nbcommentaires . '</br></div></td>';
			}
			$nombrecolonne++;
		$stml->closeCursor();
		}
		$stm->closeCursor();
	?>
</table>


</body>
