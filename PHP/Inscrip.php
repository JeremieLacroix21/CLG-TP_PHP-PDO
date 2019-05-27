<?php
session_start();
?>
<!DOCTYPE html>


<?php
$Erreur = "";
try {

    $Mybd = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>

<head>
  <link rel="stylesheet" type="text/css" href="CSS.Inscription.css">
</head>

  <div class="container">
    <h1>Inscription</h1>
    <hr>

<form method="post" onsubmit= "create()" style="border:1px solid #ccc" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
    <tr>
		<td>
		<label for="pseudonyme"><b>Pseudonyme </b></label>
		</td>
		<td>
		<input type="text" placeholder="Entrer votre pseudonyme" name="pseudonyme" required><br>
		<?php
                    if(isset($_SESSION["errPseudo"])){
                        $errorPseudo = $_SESSION["errPseudo"];
                        echo "<span id='errPseudo' style = 'color:red'>$errorPseudo</span>";
                    }
        ?>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw"><b>Mot de passe </b></label>
		</td>
		<td>
		<input type="password" placeholder="Entrer votre mot de passe" name="psw" required><br>
		<?php
            if(isset($_SESSION["errPwd"]))
			{
                $errPwd = $_SESSION["errPwd"];
               echo "<span id='errPwd' style = 'color:red'>$errPwd</span>";
             }
        ?>
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
		<input type="Text" placeholder="Entrer votre nom" name="Nom" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Prenom </b></label>
		</td>
		<td>
		<input type="Text" placeholder="Entrer votre prenom" name="Prenom" required><br>
		</td>
	</tr>
	<tr>
		<td>
		<label for="psw-repeat"><b>Adresse courriel </b></label>
		</td>
		<td>
		<input type="Text" placeholder="Entrer votre Email" name="Email" required><br>
    <?php
            if(isset($_SESSION["errEmail"]))
			{
                $errorEmail = $_SESSION["errEmail"];
                echo "<span id='errEmail' style = 'color:red'>$errorEmail</span>";
             }
        ?>
		</td>
	</tr>
</table>

    <div class="clearfix">
	<button type="submit" class="signupbtn" name="button" onclick="create()">Sign Up</button>
    <button type="button" onclick="window.location.href='login.php'" class="cancelbtn">Cancel</button>
    </div>
  </div>
  <?php
  $id = intval($_GET['inscrit']);
  if($id === 1){
    echo '<div class="Reussi">Inscription Reussi</div>';
  }
  else{
    echo '<div class="NonReussi"></div>';
  }
  unset ($_SESSION["errPwd"]);
  unset ($_SESSION["errPseudo"]);
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
	  $motdepasse = $_POST['psw'];
	  $confirmation = $_POST['psw-repeat'];
	  if(strcmp($motdepasse, $confirmation) != 0)
	  {
		  $_SESSION['errPwd'] = "Les mots de passes ne correspondent pas";
      header("location:Inscription.php?inscrit=0");
	  }
	  else
	  {
    unset($_SESSION['errPwd']);
		$stm = $Mybd->prepare("CALL VerifierUser(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
	  $username = $_POST['pseudonyme'];
	  $stm->bindParam(1, $username);
	  $stm->execute();
	  $donnees = $stm->fetch();
	  if($donnees[0] === 'Y')
	  {
		 $_SESSION['errPseudo'] = "Pseudonyme deja utilise";
     header("location:Inscription.php?inscrit=0");
	  }
	  else
	  {
    unset($_SESSION['errPseudo']);
		 $stm->closeCursor();
		 $stm = $Mybd->prepare("CALL VerifierEmail(?)", array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
		 $email = $_POST['Email'];
		 $stm->bindParam(1, $email);
		 $stm->execute();
		 $donnees = $stm->fetch();
     $find1 = strpos($email, '@');
     $find2 = strpos($email, '.');
		  if($donnees[0] == 'Y' ||$find1 == false || $find2 == false)
		  {
        if ($donnees[0] == 'Y' )
        {
        	$_SESSION['errEmail'] = "Adresse courriel deja utilise";
          header("location:Inscription.php?inscrit=0");
        }
        else {
          $_SESSION['errEmail'] = "Adresse courriel incorrect";
          header("location:Inscription.php?inscrit=0");
        }
		  }
		  else
		  {
      unset($_SESSION['errEmail']);
			Try {
			$stmt1 = $Mybd->prepare("INSERT INTO Membres(Pseudonyme, MotDePasse,Nom,Prenom,Email) VALUES (?,?,?,?,?)");
			$stmt1->bindParam(1, $pseudonyme);
			$stmt1->bindParam(2, $motdepasse);
			$stmt1->bindParam(3, $nom);
			$stmt1->bindParam(4, $prenom);
			$stmt1->bindParam(5, $email);
			$stmt1->bindParam(6, $admin);
      $stmt1 = $Mybd->prepare("INSERT INTO Membres(Pseudonyme, MotDePasse,Nom,Prenom,Email) VALUES (:fpseudo,:fmdp,:fnom,:fprenom,:femail)");
      $allo = $stmt1->execute([
    'fpseudo' => $_POST['pseudonyme'],
    'fmdp' => $_POST['psw'],
    'fnom' => $_POST['Nom'],
    'fprenom' => $_POST['Prenom'],
    'femail' => $_POST['Email']
  ]);
        if($allo == 1)
        {
          header("location:Inscription.php?inscrit=1");
        }
        else {
          header("location:Inscription.php?inscrit=0");
        }
		}
		catch (PDOException $e)
		{
			echo('Erreur de connexion: ' . $e->getMessage()); exit();
		}
		  }
		 $stm->closeCursor();
	  }
    }
  }
 ?>
</form>
