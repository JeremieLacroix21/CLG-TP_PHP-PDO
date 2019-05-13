<?php
session_start();
?>
<!DOCTYPE html>


<?php
try {
    $Mydb = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24', 'equipe24', '2hv6ai74');

    echo 'connexion reussi';
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>

<form action="action_page.php" style="border:1px solid #ccc">

<head>
  <link rel="stylesheet" type="text/css" href="CSS.Inscription.css">
</head>

  <div class="container">
    <h1>Inscription</h1>
    <hr>

<table>
    <tr>
		<td>
		<?php
                    if(isset($_SESSION["errPseudo"])){
                        $errorPseudo = $_SESSION["errPseudo"];
                        echo "<span>$errorPseudo</span>";
                    }
                ?>
				</br>
		<label for="pseudonyme"><b>Pseudonyme </b></label>
		</td>
		<td>
		<input type="text" placeholder="Entrer votre pseudonyme" name="pseudonyme" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw"><b>Mot de passe </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre mot de passe" name="psw" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Confirmation </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer la confirmation du mot de passe" name="psw-repeat" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Nom </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre nom" name="Nom" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Prenom </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre prenom" name="Prénom" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<?php
                    if(isset($_SESSION["errEmail"])){
                        $errorEmail = $_SESSION["errEmail"];
                        echo "<span>$errorEmail</span>";
                    }
                ?>
				</br>
		<label for="psw-repeat"><b>Adresse courriel </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre Email" name="Email" required><br>
		</td>
	</tr>
</table>

    <div class="clearfix">
	<button type="submit" class="signupbtn" onclick="Verify_Valid();">Sign Up</button>
     <button type="button" class="cancelbtn">Cancel</button>
    </div>
  </div>
</form>

<script>
function Verify_Valid()//verifie si le nom ou le email est deja utilis�
{
  $username = $_POST['username'];
  $email = $_POST['Email'];
  
}
function create_user()
{


}



</script>
