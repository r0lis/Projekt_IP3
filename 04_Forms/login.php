<?php
// prisla data?
// ne => fomular
// ano =>
    // mam izivatele => prihlasit a presmerovat
    // nemam usera => formular


$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');

if($name !== null && $password !== null){
    require_once "inc/users.inc.php";
    foreach ($users as $userId => $user){
        if ($user['name'] === $name && $user['password'] === $password){
            session_start();
            $_SESSION['user'] = $userId;
            header("Location: home.php");
            exit;
        }
    }
}
?>
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
if($name !== null && $password !== null){
    echo "<p> Invalit login</p>";
}
?>
<form method="post">
    Jméno: <input type="text" name="name" value="<?= $name ?>" placeholder="vaše jméno" /><br />
    Heslo: <input type="text" name="password" placeholder="heslo" /><br />
    <input type="submit" value="Odeslat" /></form>
</body>
</html>