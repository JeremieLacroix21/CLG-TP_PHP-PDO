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

	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$stm = $Mybd->prepare("CALL VerifierCompte(?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
			$username = $_POST['username'];
			$password = $_POST['password'];
			$stm->bindParam(1, $username);
			$stm->bindParam(2, $password);
			$stm->execute();
			$donnees = $stm->fetch();
			if($donnees[0] === 'N')
			{
			 	$Erreur= "Invalid username or password";
			}
			else {
				$_SESSION['username'] = $username;//Store username to session for futher authorization
				$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
				$stm = $Mybd->prepare("CALL InsertionConnection(?,?,?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
				$Comment = $_POST['Commentaire'];
				$stm->bindParam(1, $username);
				$stm->bindParam(2, $Ip);
				$stm->bindParam(3, $Date);
				$Date= date('Y-m-d H:i:s');
				$Ip = $_SERVER['REMOTE_ADDR'];
				$stm->execute();
				header("location:index.php");
				exit;
			}
		}
	?>

<!DOCTYPE html>

<head>
  <link rel="stylesheet" type="text/css" href="CSS.login.css">
</head>

<body>
	<h1>Galerie Photo</h1>
<div class="container">
	<form action = "" method = "post">
		<label>Pseudonyme  :</label>
			<input type="text" placeholder="Entrer votre pseudonyme" name ="username" required><br>
		<label>Mot de Passe  :</label>
			<input type="password" placeholder="Entrer votre mot de passe" name ="password" required>
		<br>
			<button type="submit" value = " Submit ">Se connecter</button>
			<button type="button"  onclick="window.location.href='Inscrip.php?inscrit=0'"style="background-color:grey">S'inscrire</button>
	</form>
	<?php	echo ($Erreur); ?>
</div>
</body>
