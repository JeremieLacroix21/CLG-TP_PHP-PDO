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
<navigation>
	<div class="topnav">
	<a href="Photo.php">Galerie Photo</a>
		<a href="#about">About</a>

		<?php
		$username = $_SESSION['username'];
		echo ("<a style='float:right;' href='#Profil'> $username </a>");
		?>
		<a style="float:right;" href="#logout"> logout </a>

	</div>
</navigation>
</header>

<?php

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
{ 
	echo('Erreur de connexion: ' . $e->getMessage());exit();
}
$Mybd=null;

?>

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
					<th><a href='#User'> <?php echo($UsernameOwner) ?> </a>
					<form action="" method="POST">
					<?php if($username == $UsernameOwner || $username == 'Admin')
					{
					echo ("<input style='float:right' type='submit' value='delete' name='PhotoDelete'>");
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
					$stm1 = $Mybd1->prepare("SELECT Pseudonyme,Message,idCommentaires from Commentaires where IdImages = $idPhoto" );
					$stm1->execute();
					while ($donnees1 = $stm1->fetch())
					{
						echo $donnees1[0].': '.$donnees1[1].'      ';

						if($donnees1[0] == $username)
						{
							echo "<input type='submit' value='$donnees1[2]' name='zero'>";
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
</html>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {

			if($_POST['Commentaire'] != ""){
			$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
			$stm = $Mybd->prepare("CALL InsertionCommentaire(?,?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
			$Comment = $_POST['Commentaire'];
			$stm->bindParam(1, $idPhoto);
			$stm->bindParam(2, $username);
			$stm->bindParam(3, $Comment);
			$stm->execute();
			$donnees = $stm->fetch();
			header("Refresh:0");
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
	header("Refresh:0");
}

function Deletephoto($Q,$W){
	$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	$stm = $Mybd->prepare("select DeleteImage(?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
	$stm->bindParam(1, $id1);
	$stm->bindParam(2, $id2);
	$id1 = $W;
	$id2 = $Q;
	$stm->execute();
	header("Location:Photo.php");
}

if (isset($_POST["zero"]))
{
	DeleteComment($_POST["zero"]);
}

if (isset($_POST["PhotoDelete"]))
{
	Deletephoto($idPhoto,$username);
}
?>