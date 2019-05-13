<?php
session_start();
?>

<!DOCTYPE html>



<form>

<head>
  <link rel="stylesheet" type="text/css" href="CSS.login.css">
  
  
  <?php
try {
    $Mydb = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24', 'equipe24', '2hv6ai74');
    
    echo 'connexion reussi';
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>
  
  
  
</head>

	<h1>Photo </h1>
  <div class="container">
  
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
		<span class="psw">Forgot <a href="#">password?</a></span>
	</td>
	</tr>
</table>
<?php
                    if(isset($_SESSION['errMsg'])){
                        $error = $_SESSION['errMsg'];
                        echo "<span>$error</span>";
                    }
					
                ?>
				</br>
	<button type="submit"  onclick="verify_existence();">Se connecter</button>
	<button type="button" style="background-color:grey">S'inscrire</button>
	
  </div>
</form>


<script>



function verify_existence() {
<?php   
    $username = $_POST['username'];
    $password = $_POST['password'];
	$sql = "SELECT * FROM Membres WHERE Pseudonyme=$username and MotDePasse=$password";
    $query = $Mydb->query($sql);
    $numrows = $query->rowcount();
	
         if($numrows == 1)
         {
            $_SESSION['username'] = $username; //Store username to session for futher authorization 
            header("Location: inscription.php"); //Redirect user to home page
         }
         else {
                $_SESSION['errMsg'] = "Invalid username or password";
         }
        header("Location: login.php"); //Redirect user back to your login form
	?>
}



</script>

