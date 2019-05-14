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
				$resultat = $Mybd->query("SELECT * FROM Membres");
				
				echo ($resultat->rowCount());
				$resultat->closeCursor();
				}
				catch (PDOException $e)
				{ echo('Erreur de connexion: ' . $e->getMessage()); exit(); } 
	?>

<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		header("Location: inscription .php");
				$username = $_POST['username'];
				$password = $_POST['password'];

				$resultat = $Mybd->query("SELECT * FROM Membres WHERE Pseudonyme= '$username' and MotDePasse = '$password'");

				$numrows = $resultat->rowCount();

						if($numrows == 1)
						{
								$_SESSION['username'] = $username; //Store username to session for futher authorization 
								header("Location: inscription.php"); //Redirect user to home page
								$Erreur=  "User connecter";
						}
						else {
										$_SESSION['errMsg'] = "Invalid username or password";
										$Erreur= "erreur";
						}
					header("Location: Login.php"); //Redirect user back to your login form
			
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
		<table>
			<tr>
				<td>
					<label for="pseudonyme"><b>Pseudonyme </b></label>
				</td>
				<td>
					<input type="text" placeholder="Entrer votre pseudonyme" name="username" required><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="psw"><b>Mot de Passe</b></label>
				</td>
				<td>
					<input type="password" placeholder="Entrer votre mot de passe" name="password" required>
				</td>
			</tr>
			<tr>
			<td>
			</td>	
			<td>
			</td>
			</tr>
		</table>
			<button type="submit" value = " Submit ">Se connecter</button>
			<button type="button" style="background-color:grey">S'inscrire</button>
		</div>
	</form>
</body>