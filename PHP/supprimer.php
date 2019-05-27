<?php
session_start(); 
?>

<!DOCTYPE html>
<header>
</header>


<body>
<p>
Êtes-vous sur de vouloir supprimer : <?php echo $_GET['id'] ?>
</p>
<button value='yes' onclick='supprimer()'> oui</button>
<button onclick="location.href = 'Admin.php';" >non</button>

</body>

<script>
function supprimer()
{
	<?php 
		try {
			
			
			
		}
	
	
	
	?>
	
	
}




</script>