<?php
$id = filter_input(INPUT_GET,
    'roomId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range"=> 1]]
);

if ($id === null || $id === false){
    http_response_code(400);
    $status = "bad_request";
}else{

require_once "inc2/database.php";

$stmt = $pdo->query("SELECT * FROM room where  room_id = $id");
//$stmt = $pdo->prepare("SELECT * FROM room where  room_id = ?");
//$stmt->execute(["roomId" => $id]);
if ($stmt->rowCount() === 0){
    http_response_code(404);
    $status = "not_found";
}else{
    $room = $stmt->fetch();
    $status = "OK";
    var_dump($room);
}
$room = $stmt->fetch();
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
switch ($status){
    case "bad_request";
        echo "<h1>Bad Reguest</h1>";
        break;
    case "not_found";
        echo "<h1>Not found</h1>";
        break;
    case "OK";

        break;
}
?>
</body>
</html>

