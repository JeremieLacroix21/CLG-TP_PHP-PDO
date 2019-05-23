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
			$_SESSION['username'] = $username; //Store username to session for futher authorization
			header("location:Photo.php");
			exit;
		}
	}
?>


<!DOCTYPE html>
<header>
</header>
<body>
</body>
