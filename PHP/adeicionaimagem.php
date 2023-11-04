<?php 
$targer_dir = "/home/projetoscti/www/projetoscti14/Imagens/Produtos/";
$targer_file = $targer_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

$imageFileType = strtolower(pathinfo($targer_file,PATHINFO_EXTENSION));

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
if (file_exists($targer_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";

    $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, JPEG, PNG files are allowed.";

    $uploadOk = 0;
}


// if everything is ok, try to upload file
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targer_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

    } else {
        echo "Sorry, there was an error uploading your file.";
    }

} else {
    echo "Sorry, your file was not uploaded.";
}

?>