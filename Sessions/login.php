<?php
session_start();


?>
<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php
//vložím menus
$_SESSION["prihlasen"] = true;
$_SESSION["jmeno"] = "Lukáš";

?>
</body>
</html>
