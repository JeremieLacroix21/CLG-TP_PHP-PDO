


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
<html>
<header>
<title>Galerie d'image/Admin</title>
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
<div  style="border:1px solid #ccc" >
 <!-- Changement mot de passe -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
	<h1>Changement de mot de passe pour <?php  echo $_SESSION['Modify']; ?></h1>
	<tr>
		<td>
		<label for="psw"><b>Nouveau mot de passe: </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre nouveau mot de passe" name="psw" required><br>
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
<?php
	if(isset($_SESSION["errNewPwd"]))
	{
		$errPwd = $_SESSION["errNewPwd"];
		echo "<span id='errNewPwd' style = 'color:red'>$errPwd</span>";
	}
	$id = intval($_GET['reussi']);
	if($id === 1){
		echo '<div class="Reussi">Changement de mot de passe reussi</div>';
	}
	else{
		echo '<div class="NonReussi"></div>';
	}
?>
    <div class="clearfix">
	<button type="submit" class="signupbtn" name="buttonMDP" >Confirmer</button>
    </div>
</form>

<?php
unset ($_SESSION["errNewPwd"]);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buttonMDP']))
{
 unset ($_POST["buttonMDP"]);
 $motdepasse = $_POST['psw'];
 $confirmation = $_POST['psw-repeat'];
 if(strcmp($motdepasse, $confirmation) != 0)
 {
	 $_SESSION['errNewPwd'] = "Les mots de passes ne correspondent pas";
		header("location: modifier.php?reussi=0");
 }
 else {
	 try {
		 $stm = $Mybd->prepare("CALL ChangePassword(?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
		 $user = $_SESSION['Modify'];
  	 $stm->bindParam(1, $user);
  	 $stm->bindParam(2, $motdepasse);
  	 $total = $stm->execute();
		 if($total == 1)
		 {
			 header("location: modifier.php?reussi=1");
		 }
	 } catch (\Exception $e) {
	 	$_SESSION['errNewPwd'] = $e->getMessage();
		header("location: modifier.php?reussi=0");
	 }
}
}
?>
</div>

</body>

<footer>
<p style="text-align:center;">
site faite par Charles Bourgeois, Jérémie Lacroix, et Mathieu Sévignye -- 2019 -- TP FINALE PDO 
</p>
</footer>

</html>