<?php
// Start the session
session_start();
?>
<!DOCTYPE HTML>  
<html>
<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
  .img{width: 50px;height: 50px;};
</style>

<script>
    function myFunction(id) {
   var result = confirm("Realmente desea borrar?");
if (result) {
    location.href='eliminar.php?eliminar='+id;
}


}
</script>
</head>
<body style="font-family: verdana">

<form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">  
  Nombre <input type="text" name="nombre"><br>
  Contraseña <input type="text" name="pass"><br>
  E-mail <input type="text" name="email"><br>

  <input type="submit" name="submit" value="Registrar">
   
</form>
<?php
if(isset($_POST["submit"]))
{

   $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $conn = new PDO("mysql:host=$servername;dbname=id2418557_alta", $username, $password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

    try {
        
        $newDateymd=rand(2000,2017) . str_pad(rand(1,12),2,"0",STR_PAD_LEFT) . str_pad(rand(1,25),2,"0",STR_PAD_LEFT);
        $nombre=$_POST["nombre"];
        $pass=$_POST["pass"];
        $email=$_POST["email"];

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO alta (nombre, pass, email, fecha) VALUES ('$nombre','$pass','$email',  '$newDateymd')";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Usuario dado de alta correctamente";
        //$_SESSION["user"] = $nombre;

        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }


    $conn = null;
}
?>
  </body>

</html>