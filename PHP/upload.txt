<?php
session_start();
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType =  strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
 // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
 }
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		try {
			$Mybd =	new PDO('mysql:host=167.114.152.54;dbname=dbequipe24;charset=utf8','equipe24','2hv6ai74',array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
			$stmt3 = $Mybd->prepare("INSERT INTO Images(Titre,Description,Url,Pseudonyme,Date) VALUES(?,?,?,?,?)");

			$Titre = $_POST['Titre'];
			$pseudonyme = $_SESSION['username'];
			$Description =  $_POST['Description'];
			$Name = $_FILES['fileToUpload']['name'];
			$Url = "Images\\".$Name;
			$Date = date('y-m-d');
			$stmt3->bindParam(1, $Titre);
			$stmt3->bindParam(2, $Description);
			$stmt3->bindParam(3, $Url);
			$stmt3->bindParam(4, $pseudonyme);
			$stmt3->bindParam(5, $Date);
			$stmt3->execute();

		} catch (PDOException $e) {
					print "Erreur !: " . $e->getMessage() . "<br/>";
					die();
			}


    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

echo " cliquer <a href='index.php'>ici</a> pour retourner a la gallerie d'image";

?>
