<?php
session_start();
?>
<!DOCTYPE html>
<link rel="stylesheet" href="CSS.PhotoVue.css">

<html>
<header>
<navigation>
	<div class="topnav">
		<a class="active" href="#home">Home</a>
		<a href="#about">About</a>

		<?php
		$username = $_SESSION['username'];
		echo ("<a style='float:right;' href='#Profil'> $username </a>");
		?>
		<a style="float:right;" href="#logout"> logout </a>

	</div>
</navigation>
<header/>

<?php

$idPhoto = intval($_GET['id']);


try
{
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm = $Mybd->prepare("SELECT GetUsername(?)" );
	$stm->bindParam(1, $id);
	$id = $idPhoto;
	$stm->execute();
	if ($donnees = $stm->fetch())
	{
	$UsernameOwner = $donnees[0];
	}
	$stm->closeCursor();
	
}
catch (PDOException $e)
{ echo('Erreur de connexion: ' . $e->getMessage());exit();}
$Mybd=null;

?>

<body>
	<div class="photolist">
		<div class='photo'>
			<table style="width:100%;">
				<tr>
					<th><a href='#User'> <?php echo($UsernameOwner); ?> </a></th>
				</tr>
				<tr>
					<th><img src='images/1.jpg' ></th>
				</tr>
			</table>
		</div>
		<div class="commentaire" >
		<p>
			<?php
				try
				{
					$Mybd1 = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
					$stm1 = $Mybd1->prepare("SELECT Pseudonyme,Message from Commentaires where IdImages = 1" );
					$stm1->execute();
					while ($donnees1 = $stm1->fetch())
					{
					echo $donnees1[0].': '.$donnees1[1].'</br>';
					}
					$stm1->closeCursor();
				}
				catch (PDOException $e)
				{ echo('Erreur de connexion: ' . $e->getMessage());exit();}
				$Mybd1=null;
			?>
		</p>
		</div>
		<input type ="text" style='width:90%;'><input type="Submit" value="Commenter">
		<br>
	</div>
</body>
</html>