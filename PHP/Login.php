<?php
session_start();
?>
<?php

			$Erreur = "";
			try {
					
					$Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
	
					echo 'En ligne';
			} catch (PDOException $e) {
					print "Erreur !: " . $e->getMessage() . "<br/>";
					die();
			}
	?>

<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
				$username = $_POST['username'];
				$password = $_POST['password'];

				$resultat = $Mybd->query("SELECT * FROM Membres WHERE Pseudonyme= '$username' and MotDePasse = '$password'");

				$numrows = $resultat->rowCount();

						if($numrows == 1)
						{
								$_SESSION['username'] = $username; //Store username to session for futher authorization 
								header("location:PhotoVue.php");
								exit;
								$Erreur=  "User connecter";
						}
						else {
										$Erreur= "Invalid username or password";
						}


	}
?>

<!DOCTYPE html>

<head>
  <link rel="stylesheet" type="text/css" href="CSS.login.css">
</head>

<body>
	<h1>Photo </h1>
<div class="container">
	<form action = "" method = "post">  
		<label>Pseudonyme  :</label>
			<input type="text" placeholder="Entrer votre pseudonyme" name ="username" required><br>
		<label>Mot de Passe  :</label>
			<input type="password" placeholder="Entrer votre mot de passe" name ="password" required>
		<br>
			<button type="submit" value = " Submit ">Se connecter</button>
			<button type="button" style="background-color:grey">S'inscrire</button>
	</form>
	<?php	echo ($Erreur); ?>
</div>
</body>