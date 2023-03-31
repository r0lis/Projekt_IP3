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
      echo'<ol>';
      foreach($vitezove as  $value) {
        echo '<li>'.$value.'</li>';


    }
    
  }
   
    ?> 
    
  </body>
</html>


