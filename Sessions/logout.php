<?php
session_start();

session_destroy();
?>
<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php
$_SESSION["prihlasen"] == false;
//require_once("inc/menu.inc.php"); //vložím menu

?>
</body>
</html>