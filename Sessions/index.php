<?php

?>
<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php
//require_once("inc/menu.inc.php"); //vložím menu
session_start();
if (isset($_SESSION['prihlasen']) === true)
    var_dump("Uzivatel je prihlasen");
else
    var_dump("Uzivazel je odhlasen");
?>
</body>
</html>