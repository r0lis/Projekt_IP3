<?php
session_start();
$_SESSION["jmenoAdmin"] = "admin";
$_SESSION["hesloAdmin"] = "tajemstvi";
?>
<html>
<head>
    <title>PHP Test</title>
</head>
<body>

<form>
    <p>Your name: <input id="inputName" type="text" name="name" /></p>
    <p>Your password: <input type="text" name="password" /></p>
    <p><input type="submit" /></p>
</form>

<?php
if(isset($_SESSION["jmenoAdmin"]) == inputName)
    header('Location: \Sessions2\index.php');

var_dump($_SESSION["jmenoAdmin"]);


?>
</body>
</html>