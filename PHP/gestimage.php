<?php
session_start();
$idPhoto = intval($_GET['id']);
?>
<!DOCTYPE html>
<link rel="stylesheet" href="CSS.PhotoVue.css">
<script src="jquery-3.3.1.js"></script>
<script src="jquery-3.3.1.min.js"></script>

<html>

<header>
<title>Galerie d'image/Image</title>
</header>
<?php

try
{
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm = $Mybd->prepare("Select GetUsername(?)" );
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
{
	echo('Erreur de connexion: ' . $e->getMessage());exit();
}

?>

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
  <a href="index.php">Galerie Photo</a>
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
			setcookie("User", null , -1);
		
	    session_unset();
		header("location:index.php");
			$_SESSION['logout'] = "set";
	    
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

<?php

try
{
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm = $Mybd->prepare("Call GetUrlImage(?)" );
	$stm->bindParam(1, $id);
	$id = $idPhoto;
	$stm->execute();
	if ($donnees = $stm->fetch())
	{
	$Url = $donnees[0];
	}
	$stm->closeCursor();

}
catch (PDOException $e)
{
	echo('Erreur de connexion: ' . $e->getMessage());exit();
}
$Mybd=null;

?>



<body>



	<div class="photolist">
		<div class='photo'>
			<table style="width:100%;">
				<tr>
					<th><b> <?php echo($UsernameOwner) ?> </b>
					<form action="" method="POST">
					<?php if($Username == $UsernameOwner || $Username == 'Admin')
					{
					echo ("<input style='float:right' type='submit' value='delete photo' name='PhotoDelete'>");
					}
					?>
					</form>
				</th>
				</tr>
				<tr>
					<th><img src= '<?php echo $Url ?>' ></th>
				</tr>
			</table>
		</div>
		<div class="commentaire" method="post" >
		<form action="" method="POST">
			<?php
				try
				{
					$Mybd1 = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
					$stm1 = $Mybd1->prepare("CALL Getcomment(?)" );
					$stm1->bindParam(1,$idPhoto);
					$stm1->execute();
					while ($donnees1 = $stm1->fetch())
					{
						echo $donnees1[3]."  ".$donnees1[0].': '.$donnees1[1].'      ';

						if($donnees1[0] == $Username || $Username == 'Admin')
						{
							echo "<button type='submit' value='$donnees1[2]' name='zero'> delete </button>";

						}
						echo '</br>'.'</br>';
					}
					$stm1->closeCursor();
				}
				catch (PDOException $e)
				{ echo('Erreur de connexion: ' . $e->getMessage());exit();}
				$Mybd1=null;
			?>
			</form>
		</div>
		<form method="post">
			<input type ="text" style='width:90%;' name="Commentaire"><input type="Submit" value="Commenter">
		</form>
	</div>
</body>


<footer>
<p style="text-align:center;">
site faite par Charles Bourgeois, Jérémie Lacroix, et Mathieu Sévignye -- 2019 -- TP FINALE PDO 
</p>
</footer>





</html>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"&& !isset($_SESSION['logout']) ) {

			if($_POST['Commentaire'] != ""){
			$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
			$stm = $Mybd->prepare("CALL InsertionCommentaire(?,?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
			$Comment = $_POST['Commentaire'];
			$stm->bindParam(1, $idPhoto);
			$stm->bindParam(2, $Username);
			$stm->bindParam(3, $Comment);
			$stm->execute();
			$donnees = $stm->fetch();
			header("location:gestimage.php?id=$idPhoto");
			}
	}
?>

<?php
function DeleteComment($id){
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm = $Mybd->prepare("CALL DeleteCommentaires(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
	$stm->bindParam(1, $id1);
	$id1 = $id;
	$stm->execute();
}

function Deletephoto($Q,$W){
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm = $Mybd->prepare("select DeleteImage(?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
	$stm->bindParam(1, $id1);
	$stm->bindParam(2, $id2);
	$id1 = $W;
	$id2 = $Q;
	$stm->execute();

}


function Deletefromfiles($idp)
{	
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm2 = $Mybd->prepare("CALL GetUrlImage(?)");
	$stm2->bindParam(1, $id);
	$id = $idp;
	echo $id;
	$stm2->execute();
	while ($donnees = $stm2->fetch())
	{
		echo $donnees[0];
	$filename = $donnees[0];
	}
	if (file_exists($filename)) {
    unlink($filename);
    echo 'File '.$filename.' has been deleted';
    } else {
    echo 'Could not delete '.$filename.', file does not exist';
    }
	header("location:gestimage.php?id=$idPhoto");
}

if (isset($_POST["zero"]))
{
	DeleteComment($_POST["zero"]);
	header("location:gestimage.php?id=$idPhoto");
}

if (isset($_POST["PhotoDelete"]))
{
	
	Deletefromfiles(intval($_GET['id']));
	Deletephoto(intval($_GET['id']),$Username);
	header("Location:index.php");
}

	
?>





