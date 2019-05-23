<?php
session_start();
?>
<!DOCTYPE html>
<link rel="stylesheet" href="CSS.PhotoVue.css">


<header>
<navigation>
	<div class="topnav">
		<a class="active" href="#home">Home</a>
		<a href="#about">About</a>

		<?php
		$username = $_SESSION['username'];
		echo ( $username);
		?>
		<a style="float:right;" href="#logout"> logout </a>

	</div>
</navigation>
<header/>

<body>

	<div class="photolist">
		<div class='photo'>
			<table style="width:100%;">
				<tr>
					<th><a href='#User'>username</a></th>
				</tr>
				<tr>
					<th><img src='images/1.jpg' ></th>
				</tr>
			</table>
		</div>
		<div class="commentaire" >
		<p>
			yo

		</p>
		</div>
		<input type ="text" style='width:90%;'><input type="Submit" value="Commenter">
		<br>
	</div>

</body>
