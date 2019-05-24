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
<link rel="stylesheet" href="CSS.Admin.css">


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

</header>

<body>
	<div>
	<h1>Derniere connexion </h1>
		<table>
			<tr>
				<th>Pseudonyme</th>
				<th>IP</th>
				<th>Date et heure</th>
			</tr>
			<?php
				try
				{
					$Mybd1 = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
					$stm1 = $Mybd1->prepare("CALL AfficherConnexion()" );
					$stm1->execute();
					while ($donnees1 = $stm1->fetch())
					{						
							echo 	"<tr><td>$donnees1[0]</td>
										<td>$donnees1[1]</td>
										<td>$donnees1[2]</td><tr>";							
					}
					$stm1->closeCursor();
				}
				catch (PDOException $e)
				{ echo('Erreur de connexion: ' . $e->getMessage());exit();}
				$Mybd1=null;
			?>
		</table>
	</div>
</body>
