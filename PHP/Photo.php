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
?>

<body>
<navigation>
<div class="topnav">
  <a href="Photo.php">Galerie Photo</a>
  <a href="Ajout.php">Ajouter une photo</a>
	<?php
	if($admin == 1){
		echo ("<a href='Admin.php'>Admin</a>");
	}
  ?>
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
	  echo "<a style='float:right;' href='Profil.php'> $Username </a>";
	}
  ?>
</div>
</navigation>

<?php
	$resultat = $Mybd->query("SELECT id FROM Images");
	?>
<table>
	<tr>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow' >
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
	</tr>
	<tr>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow' >
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
	</tr>
	<tr>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow' >
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/2.jpg' alt='Snow'>
		</td>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
		<td>
		<img src='images/1.jpg' alt='Nature' >
		</td>
	</tr>
</table>

<body/>
