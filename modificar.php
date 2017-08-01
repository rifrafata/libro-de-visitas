<?php
// Start the session
session_start();

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">
    .nombre{margin-left: 23px;}
    .fecha{margin-left: 34px;}
</style>

</head>





<?php


if ($_SESSION["user"]=="rafael" )
  {
  if(isset($_GET["mod"]))
   {
 	$id=$_GET["mod"];

 	 $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";



     $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    
   
        $sql = "SELECT *  FROM comentarios WHERE id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
         {

         while($row = $result->fetch_assoc())
             {
         
             	 echo '<form method="post"  action="modificar.php" >  ';
				 echo ' Nombre <input type="text" name="nombre" class="nombre" value="'. $row['nombre_user'].'"><br>';
				 echo ' Fecha <input type="text" name="fecha" class="fecha" value="'. $row["Fecha"].'"><br>';
				 echo ' Comentario <textarea name="message" rows="5" >'. $row["Comentario"].'</textarea><br>';
                 echo ' <input type="hidden" name="hid" value="'. $row['id'].'"><br>';
				 echo '  <input type="submit" name="modificar" value="Modificar"><br>';
			
            }
           
        }
         else
            echo "0 results";

         $conn->close();
  }

if(isset($_POST["modificar"]))
{

     $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
  
    $conn = new PDO("mysql:host=$servername;dbname=id2418557_alta", $username, $password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

     try {
        
       
       
        $nombre=$_POST["nombre"];
        $fecha= $_POST["fecha"];
        $com=$_POST["message"];
        $id=$_POST["hid"];

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  
        
         $sql = "UPDATE comentarios SET nombre_user='$nombre' ,Fecha='$fecha',Comentario=' $com' WHERE id=$id";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";



        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

      
  
    $conn = null;

header("Location:comentarios.php");
 
}

}
else
  echo "no tiene persisos para borrar ";
?>

</body>
</html>