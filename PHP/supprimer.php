<?php
session_start(); 
?>

<!DOCTYPE html>
<header>
</header>
<?php 
$UserToDelete = $_GET['id'];
?>

<body>
<p>
Êtes-vous sur de vouloir supprimer : <?php echo $UserToDelete; ?>
</p>
<button onclick="supprimer()"> oui</button>
<button onclick="location.href = 'Admin.php';" >non</button>

</body>

<script>
function supprimer()
{
	<?php 
		try {
			$Mybd0 = new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
			$stm0 = $Mybd0->prepare("CALL deletecompte(?)" , array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
			$stm0->bindparam(1,$UserToDelete);
			$result = $stm0->execute();
			
			header("url=Admin.php");
		} catch (PDOException $e)
				{ echo('Erreur de connexion: ' . $e->getMessage());exit();}
	
	
	
	?>
	
	
}
</script>