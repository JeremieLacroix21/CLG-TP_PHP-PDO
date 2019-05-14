<?php
session_start();
?>
<?php
			try {
					
					$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	
					echo 'connexion reussi';
			} catch (PDOException $e) {
					print "Erreur !: " . $e->getMessage() . "<br/>";
					die();
			}

			try{
				$resultat = $Mybd->query("SELECT * FROM Membres WHERE Pseudonyme= 'Admin' and MotDePasse = 'Admin123!'");
				
				echo ($resultat->rowCount());
				$resultat->closeCursor();
				}
				catch (PDOException $e)
				{ echo('Erreur de connexion: ' . $e->getMessage()); exit(); } 

	?>

<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
				$username = mysqli_real_escape_string($Mybd,$_POST['username']);
				$password = mysqli_real_escape_string($Mydb,$_POST['password']);

				$resultat = $Mybd->query("SELECT * FROM Membres WHERE Pseudonyme= '$username' and MotDePasse = '$password'");

				$numrows = $resultat->rowCount();

						if($numrows == 1)
						{
								$_SESSION['username'] = $username; //Store username to session for futher authorization 
								header("location:inscription.php");
								exit;
								$Erreur=  "User connecter";
						}
						else {
										$_SESSION['errMsg'] = "Invalid username or password";
										$Erreur= "erreur";
						}


	}
?>

<!DOCTYPE html>

<head>
  <link rel="stylesheet" type="text/css" href="CSS.login.css">
<?php	echo ($Erreur); ?>
</head>

<body>
	<h1>Photo </h1>
<div class="container">
	<form action = "" method = "post">  
		<label>Pseudonyme  :</label>
			<input type="text" placeholder="Entrer votre pseudonyme" id ="username" required><br>
		<label>Mot de Passe  :</label>
			<input type="password" placeholder="Entrer votre mot de passe" id ="password" required>
		<br>
			<button type="submit" value = " Submit ">Se connecter</button>
			<button type="button" style="background-color:grey">S'inscrire</button>
	</form>
</div>
</body>