<?php
// Start the session
session_start();
//$_SESSION["num_intentos"]=3;
 // if(empty($_SESSION["cont"]))
 // {
 //  $cont=0;
 //  $_SESSION["cont"]=  $cont ; 
 //  }

?>
<!DOCTYPE HTML>  
<html>
<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script>
    function myFunction(id) {
   var result = confirm("Realmente desea borrar?");
if (result) {
    location.href='eliminar.php?eliminar='+id;
}


}
</script>
<style>




body {font-family: "Lato", sans-serif;}

/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}

.nom{margin-left: 23px; }

.email{margin-left: 34px;}
</style>
<style type="text/css">
  .img{width: 50px;height: 50px;};
</style>


</head>
<body >
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')">Login</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Registrar</button>

</div>

<div id="London" class="tabcontent">
  <h3>Login</h3><br>
  <form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">  
  Nombre <input type="text" name="nombre" class="nom"><br><br>
  Contraseña <input type="password" name="pass"><br><br>

  <button  name="entrar" class="btn btn-primary">Entrar</button>

 
</form>

</div>


<div id="Paris" class="tabcontent">
  <h3>Registrar</h3>
  <form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >  
  Nombre <input type="text" name="nombre" class="nom" ><br><br>
  Contraseña <input type="password" name="pass" ><br><br>
  E-mail <input type="text" name="email" class="email"><br><br>
  
  <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>

   
</form> 
<?php
if(isset($_POST["registrar"]))
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
        $intentos=0;

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO alta (nombre, pass, email, fecha,n_intentos) VALUES ('$nombre','$pass','$email',  '$newDateymd','$intentos')";
        // use exec() because no results are returned
        $conn->exec($sql);
        $last_id = $conn->lastInsertId();
        echo "Usuario dado de alta correctamente";
        //$_SESSION["user"] = $nombre;

        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }


    try {
        
        $id_user=$last_id;
        $evento="Alta";

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO log (id_user, evento) VALUES ($id_user ,'$evento')";
        // use exec() because no results are returned
        $conn->exec($sql);
       // echo "Log correcto";
        //$_SESSION["user"] = $nombre;

        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

    $conn = null;
}
?>
</div>




<?php
if(isset($_POST["entrar"]))
{

  //$num_intentos=3;
  //$_SESSION["num_intentos"]=$num_intentos;

   $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $conn = new PDO("mysql:host=$servername;dbname=id2418557_alta", $username, $password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

    try {
        
           // $newDateymd=rand(2000,2017) . str_pad(rand(1,12),2,"0",STR_PAD_LEFT) . str_pad(rand(1,25),2,"0",STR_PAD_LEFT);
            $nombre=$_POST["nombre"];
            $pass=$_POST["pass"];
         

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
           // $sql = "SELECT id FROM alta WHERE nombre=$nombre AND pass=$pass";
            $stmt = $conn->prepare("SELECT id FROM alta WHERE nombre='$nombre' AND pass='$pass'"); 
            $stmt->execute();
            // use exec() because no results are returned
           if($stmt->rowCount()>0)
           {
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
            foreach($stmt->fetchAll() as $registro) { 
           
              echo "Usuario identificeado";
              $_SESSION["user"] = $nombre;
              $_SESSION["id"]=$registro["id"];

              try {
        
                  $id_user=$_SESSION["id"];
                  $evento="login";

                  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sql = "INSERT INTO log (id_user, evento) VALUES ($id_user ,'$evento')";
                  // use exec() because no results are returned
                  $conn->exec($sql);
                  //echo "Log correcto";
                  //$_SESSION["user"] = $nombre;

                  }
              catch(PDOException $e)
                  {
                  echo "Connection failed: " . $e->getMessage();
                  }
                }
           
             header("Location:comentarios.php");
             
            }
            else
            {
            
              //echo "Te quedan ". $int." intentos!";
                  echo ' <div class="panel panel-danger">
                 <div class="panel-heading">Usuario o contraseña incorrectos</div>
                 <div class="panel-body"></div>
                 </div>';
          

             


                  $id=existe_user();
                      if($id!=-1)
                      {
                        try{
                          $id_user=$id;
                          $evento="login fallido";

                          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          $sql = "INSERT INTO log (id_user, evento) VALUES ($id_user ,'$evento')";
                          // use exec() because no results are returned
                          $conn->exec($sql);
                         // echo "Log correcto";
                          //$_SESSION["user"] = $nombre;

                          }
                      catch(PDOException $e)
                          {
                          echo "Connection failed: " . $e->getMessage();
                          }
                 
                       }
             

               
                
            

           
           }
       
        
         
        }
    catch(PDOException $e)
        {
      
        echo "Connection failed: " . $e->getMessage();
        }


    $conn = null;
}


function existe_user()
{ 
    $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $conn = new PDO("mysql:host=$servername;dbname=id2418557_alta", $username, $password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

            $nombre=$_POST["nombre"];
            $pass=$_POST["pass"];
         

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
           // $sql = "SELECT id FROM alta WHERE nombre=$nombre AND pass=$pass";
            $stmt = $conn->prepare("SELECT id FROM alta WHERE nombre='$nombre'"); 
            $stmt->execute();
            // use exec() because no results are returned
           if($stmt->rowCount()>0)
             {
              $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
              foreach($stmt->fetchAll() as $registro) { 
             
              return $registro["id"];

             }
            }
            else
            {
              return -1;
            }
            
 $conn = null;
}

?>


<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
  </body>

</html>