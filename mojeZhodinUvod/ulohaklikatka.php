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
        foreach($options as $key => $displayed){
          echo "<input type='radio' name='magtype' value='$key' ";
            if (isset($_GET['magtype']))
            {
                echo "checked='checked'";
            }
    echo " >$key  ";
        }
        
        
   }

   
   
    ?> 


  
    

   
    
  </body>
</html>
