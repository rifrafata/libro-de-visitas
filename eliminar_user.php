<?php
// Start the session
session_start();

  
?>

<?php




if(isset($_GET["eliminar"]))
{
  if ($_SESSION["user"]=="rafael" )
  {
 $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
$id=$_GET["eliminar"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM alta WHERE id=$id";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;


header("Location: comentarios.php");
}
else
echo "no tiene persisos para borrar ";
}

?>