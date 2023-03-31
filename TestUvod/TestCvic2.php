
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
function podretezec($retezec){

    $prvni = strtok($retezec, " ");
    $len = mb_strlen($prvni);
    echo substr($prvni,  2);
}
$veta ="Kočičí zlato se taky blýská";
echo podretezec($veta)


?>
</body>
</html>
