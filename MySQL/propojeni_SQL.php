<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <!-- Bootstrap-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Připojení k DB</title>
    </head>
    <body>
        <?php
        $host = '127.0.0.1';
        $db = 'ip_3';
        $user = 'www-aplikace';
        $pass = 'Bezpe4n0Heslo.';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
        
        $stmt = $pdo->query('SELECT * FROM room');
        echo "Pocet radku: ".$stmt-> rowCount() . "<br>";
        
      if ($stmt->rowCount() == 0) {            
        echo "Záznam neobsahuje žádná data";
        } else {
            echo "<table class = table table - striped>";
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //nebo foreach ($stmt as $row)
            echo "<tr>";
            echo "<td>";
                //var_dump($row);
                //var_dump($row['name']);
            }
       }
        unset($stmt);
        ?>
    </body>
</html>