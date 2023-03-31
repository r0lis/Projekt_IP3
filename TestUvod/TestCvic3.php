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
$lide = [
    [
        "jmeno" => "Adam",
        "prijmeni" => "Abrahám",
        "bydliste" => "Aš",
        "vyska" => 182,
    ],
    [
        "jmeno" => "Bernard",
        "prijmeni" => "Bohatý",
        "bydliste" => "Benešov",
        "vyska" => 185,
    ],
    [
        "jmeno" => "Cyril",
        "prijmeni" => "Cipísek",
        "bydliste" => "Cizkrajov",
        "vyska" => 164,
    ],
    [
        "jmeno" => "Daniel",
        "prijmeni" => "Drahoš",
        "bydliste" => "Drahotuše",
        "vyska" => 172,
    ],
    [
        "jmeno" => "Emil",
        "prijmeni" => "Elefteriadu",
        "bydliste" => "Emauzy",
        "vyska" => 197,
    ],
];
function seznamVysokych($polelidi){
   $vysoky = [];
    foreach ($polelidi["vyska"] as $vyska){
        if ($vyska > 180){
            $vysoky . $polelidi["jmeno"] . [$polelidi["prijmeni"]];
        }
    }
    echo $vysoky;
}
echo seznamVysokych($lide)
?>

</body>
</html>

