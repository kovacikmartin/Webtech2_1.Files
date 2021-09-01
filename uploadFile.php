<?php
    $path = "";

    if(isset($_GET["dir"]))
        $path = $_GET["dir"];

    header("refresh:3; url=index.php?dir=".$path);
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $targetDir = "files/";
    
    $uploadedFile = basename($_FILES["fileToUpload"]["name"]);
    $targetFile = $targetDir . $path . "/" . $_POST["fileName"];

    $fileType = strtolower(pathinfo($uploadedFile,PATHINFO_EXTENSION));
    
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($targetFile.".".$fileType))
        $targetFile = $targetFile . time();

    $targetFile = $targetFile . "." . $fileType;
    
    // Check file size
    if (($_FILES["fileToUpload"]["error"]) === 1)
    {
        echo "File size is too large. ";
        $uploadOk = 0;
    }
    
    if ($uploadOk === 0)
        echo "Sorry, your file was not uploaded.";
    
    else
    {
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) 
            echo "File". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " uploaded.";
        else 
            echo "Sorry, there was an error uploading your file.";
    }

    echo "<br><br>You will be redirected back in 3 seconds."
?>