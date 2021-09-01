<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $dir = "files/";
    $path = "";

    if(isset($_GET["dir"]))
        $path = $_GET["dir"];

    //                            check if url contains unwanted address such as ?dir=../
    if(file_exists($dir.$path) && !str_contains($path, ".."))
        $dir = $dir . $path;
    
    else
        $path = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files uploader</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/file-size.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <h3>Folder browser with file uploading</h3>
    </header>
    <div class="tableContainer">
        <table class="display" id="dirTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    
                    date_default_timezone_set('Europe/Bratislava');

                    $dirContent = scandir($dir);
                
                    foreach($dirContent as $file)
                    {
                        
                        echo "<tr>";
                        echo "<td>";
                        if($file === ".." && !empty($path))
                        {
                            $chopOff = strrpos($path, "/");
                            if($chopOff === false)
                                $chopOff = 0;
                            $back = substr($path, 0, $chopOff);
                            
                            echo "<a href='?dir=". $back. "'>".$file."</a>";
                            
                        }                    

                        else if(is_dir($dir."/".$file) && $file !== "." && $file !== "..")
                        {   
                            if(empty($path))
                                echo "<a href='?dir=". $file . "'>".$file."</a>";
                            else
                                echo "<a href='?dir=". $path ."/". $file . "'>".$file."</a>";
                        }
                                            
                        else if($file !== "." && $file !== "..")
                        {
                            $fileName = pathinfo($file, PATHINFO_FILENAME);
                            $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $croppedFileName = substr($fileName, 0, -10);
                            
                            if(file_exists($dir."/" .$croppedFileName.".".$fileType))
                                echo $croppedFileName.".".$fileType;
                            else
                                echo $file;
                        }
                            
                        echo "</td>";

                        echo "<td>";
                        if(!is_dir($dir."/".$file))
                            echo filesize($dir."/".$file) . " bytes";
                        echo "</td>";

                        echo "<td>";
                        if(!is_dir($dir."/".$file))
                            echo date("d.m.Y G:i", filectime($dir."/".$file));
                        echo "</td>";
                                    
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="row justify-content-center formContainer">
        <form action="uploadFile.php?dir=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
        
            <div class="form-group">
                <label class="font-weight-bold" for="fileToUpload">Select file:</label>
                <input class="form-control-file" type="file" name="fileToUpload" id="fileToUpload" required>
            </div>

            <div class="form-group">
                <label class="font-weight-bold" for="fileName">File name:</label>
                <input class="form-control" type="text" name="fileName" placeholder="The name of the file..." id="fileName" required>
            </div>
            
            <input class="form-control btn btn-primary mx-auto" type="submit" value="Upload file" name="submit">
        </form>
    </div>

    <footer>
        <span>Webtech 2 - Homework 1 - </span>
        <span>Martin Kováčik</span>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>