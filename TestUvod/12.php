<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php
$vitezove = [
    "Petr Vincena",
    "Markéta Calábková",
    "Marian Poljak",
    "Martin Kubeša",
    "Jan Šuta",
    "Jan Gocník",
    "Tomáš Kremel",
];
echo(Vypis($vitezove));
function Vypis($vitezove){
    $pocet = 1;
    $table = "<table>";
    foreach($vitezove as $vitez){
        if($pocet % 2 == 0)
            $table .= "<tr style=\"background:lightgray;\">"; // ciste šeda byla moc tmava
        else
            $table .= "<tr>";

        $table .="<td>'$pocet' <td/> <td>'$vitez'</td>";
        $table .= "</tr>";
        $pocet++;
    }
    $table .= "</table>";
    return $table;
}

?>

</body>
</html>