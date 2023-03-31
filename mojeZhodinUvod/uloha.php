<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php
     
      $options = [
        "volvo" => "Volvo",
        "bmw" => "BMW",
        "trabant" => "Trabant",
        "skoda" => "Škoda"
    ];
    echo htmlSelect( "auto", $options, "skoda" );
    
   function htmlSelect($name, $options, $selected){
    $result = "<select name = $name>";
        foreach($options as $key => $displayed){
            $result .= "<option value = '$key'> $displayed<$displayed</option>";
        }
        $result .= "</selected>";
        return $result;  
   }
   
    ?> 


  
    

   
    
  </body>
</html>
