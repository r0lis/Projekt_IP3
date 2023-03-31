<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>
        Script upload
    </title>
</head>
<body class="container">
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formFile" class="form-label">Nahrajte fotku nebo video o max velikosti 8mb</label>
        <input class="form-control" type="file" id="formFile" name="formFile">
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>

<?php

if (isset($_POST["submit"])) {

    if (isset($_FILES["formFile"]) && !empty($_FILES["formFile"]["name"])) {

        $file = $_FILES["formFile"];
        $fileName = $file["name"];
        $fileSize = $file["size"];
        $fileType = $file["type"];
        $fileTmpName = $file["tmp_name"];

        if ($fileSize > 8000000) {
            exit("Tento soubor je moc velký, limit je 8 mb");
        }

        move_uploaded_file($fileTmpName, "uploaded_files/$fileName");

        switch ($fileType) {
            case "image/jpeg":
            case "image/png":
                echo "<img src='uploaded_files/$fileName' alt='Image' />";
                break;
            case "audio/mp3":
            case "video/mp4":
                echo "<video controls autoplay src='uploaded_files/$fileName' controls />";
                break;
            default:
                echo "Neznámý typ souboru";
                break;
        }
    }
}

?>
</body>
</html>