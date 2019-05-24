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
<link rel="stylesheet" href="CSS.Profil.css">
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
		echo "<a style='float:right;' href='Profil.php'> $Username </a>";
	}
	else
	{
		echo "<a style='float:right;' href='login.php'> Login </a>";
	}
  ?>
</div>
</navigation>
<div  style="border:1px solid #ccc" >
 <!-- Changement mot de passe -->
<form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
	<h1>Changement de mot de passe</h1>
	<tr>
		<td>
		<label for="psw"><b>Nouveau mot de passe: </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre mot de passe" name="psw" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Confirmation: </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer la confirmation du mot de passe" name="psw-repeat" required><br>
		</td>
	</tr>
</table>
    <div class="clearfix">
	<button type="submit" class="signupbtn" name="button" >Confirmer</button>
    </div>
</form>
 <!-- Changement Email -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
	<h1>Changement de Email</h1>
	<tr>
		<td>
		<label for="psw"><b>Nouveau Email: </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre mot de passe" name="psw" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Confirmation: </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer la confirmation du mot de passe" name="psw-repeat" required><br>
		</td>
	</tr>
</table>
    <div class="clearfix">
	<button type="submit" class="signupbtn" name="button" >Confirmer</button>
    </div>
</form>
</div>

</body>
