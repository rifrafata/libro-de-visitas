<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

.fecha_filtro{width: 200px;}
.coment{width: 400px;}

</style>

<script type="text/javascript">
  function validar()
  {
  var fname = document.getElementById("comment").value;
   if( fname.length > 5)
       return true;
   else 
     alert("Campo comentarios debe no estar vacio");
   return false;
  }


function myFunction(id)
 {
   var result = confirm("Realmente desea borrar?");
    if (result)
     {
        location.href='eliminar.php?eliminar='+id;
    }
  }

 function eliminar(id) 
 {
    var result = confirm("Realmente desea borrar?");
     if (result) 
     {
        location.href='eliminar_user.php?eliminar='+id;
     }
}


</script>
</head>
<body>


<a href="logout.php" class=""> <?php echo $_SESSION["user"]." Salir" ?></a>
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')">Comentar</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Ver Comentarios</button>
  <button class="tablinks" onclick="openCity(event, 'perfil')">Perfil</button>
  <button class="tablinks" onclick="openCity(event, 'export')">Exportar Mensajes</button>
   <button class="tablinks" onclick="openCity(event, 'admin')">Administrar</button>
</div>

<div id="export" class="tabcontent">
  <h3>Exportar Mensajes de <?php echo $_SESSION["user"] ?></h3><br>

    
    <form method="post"  action="exportar_mensajes.php" >  
      <input type="hidden" name="id_cliente" value=" <?php echo $_SESSION["id"]   ?>">
    <button type="submit" name="registrar" class="btn btn-primary">Exportar</button>

   
</form> 

</div>



<div id="perfil" class="tabcontent">
  <h3>Perfil</h3><br>

  <?php

   $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    $id=$_SESSION["id"];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  alta WHERE id=$id ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Datos de tu perfil</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>Nombre</th>';
            echo '<th>Contraseña</th>';
            echo '<th>E-mail</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["nombre"]."</td><td>".$row["pass"]."</td> <td>".$row["email"]."</td><td><a href=modificar_user.php?mod=".$row['id'].">&nbsp&nbspModificar</a></td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
        echo "0 results";



    $conn->close(); 
  

  ?>
</div>

<div id="admin" class="tabcontent">
  <h3>Administrar</h3><br>

  <?php

  if ($_SESSION["user"]=="rafael" )
  {
   $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  comentarios  ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Todos los mensajes</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>Nombre</th>';
            echo '<th>Fecha</th>';
            echo '<th>Comentario</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["nombre_user"]."</td><td>".$row["Fecha"]."</td> <td>".$row["Comentario"]."</td><td><a href=' javascript:myFunction(".$row['id'].")'>Eliminar</a></td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
        echo "0 results";


    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  alta  ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Todos los usuarios</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>Nombre</th>';
            echo '<th>Contraseña</th>';
            echo '<th>E-mail</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["nombre"]."</td><td>".$row["pass"]."</td> <td>".$row["email"]."</td><td><a href=' javascript:eliminar(".$row['id'].")'>Eliminar</a><a href=modificar_user.php?mod=".$row['id'].">&nbsp&nbspModificar</a></td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
        echo "0 results";



    $conn->close(); 


  $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  log  ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Todos los Logs</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>ID Usuario</th>';
            echo '<th>Evento</th>';
            echo '<th>Fecha</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["id_user"]."</td><td>".$row["evento"]."</td> <td>".$row["fecha"]."</td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
        echo "0 results";

    

    //contar los mensajes de cada usuario
   $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 
     $sql= "SELECT nombre, count(Comentario) as NumMensajes FROM comentarios as MEN left join alta as USU ON MEN.id_user=USU.id GROUP BY nombre order by NumMensajes desc";
    
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Nº de mensajes</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>Nombre</th>';
            echo '<th>Nº Comentarios</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["nombre"]."</td><td>".$row["NumMensajes"]."</td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
        echo "0 Mensajes";

   
    $conn->close();
    


   //crear PDF con mensajes

    //   



  }
  else 
    echo"No tiene permisos para ver esta pagina";


?>
</div>



<div id="London" class="tabcontent">
  <h3>Comentar</h3><br>
 <?php
 if(isset( $_SESSION["user"]))
   echo $_SESSION["user"]." escribe un Comentario";
 else
  header("Location:login.php");
 ?>
   <form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" onsubmit="return validar();">  
 <div class="form-group">
 <div class ="coment">
  <label for="comment">Comentario:</label>
  <textarea class="form-control" rows="5" id="comment" name="coment"></textarea>
</div>
 </div>
 <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
  
</form>

 <?php

   if(isset($_POST["submit"]))
   {

    $id_user=$_SESSION["id"];
    $user=$_SESSION["user"];
    $comentario=$_POST["coment"];

$servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=id2418557_alta", $username, $password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO comentarios (id_user, Comentario,nombre_user) VALUES ('$id_user','$comentario','$user')";
        // use exec() because no results are returned
        $conn->exec($sql);
         echo ' <div class="panel panel-success">
                 <div class="panel-heading">Comentario Guardado</div>
                 <div class="panel-body"></div>
                 </div>';
      
                  
                      if($id!=-1)
                      {
                        try{
                         
                          $evento="ha puesto un comentario";

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
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

        $conn = null;
     
   }

 ?>


</div>

<div id="Paris" class="tabcontent">
  <h3>Ver Comentarios</h3>
 
  <form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >  
    <div class="form-group">
    <div class ="fecha_filtro">
       <label for="sel1">Seleccionar un usuario de la lista:</label>
      <select class="form-control" id="sel1" name="select">
      <?php
          $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          $conn->set_charset("utf8") ;
          // Check connection
          if ($conn->connect_error) 
          {
              die("Connection failed: " . $conn->connect_error);
          } 

          $sql=  "SELECT  nombre FROM  alta ";
          //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
          $result = $conn->query($sql);
          
         // var_dump($result);
          if ($result->num_rows > 0)
           {
             while($row = $result->fetch_assoc())
              {
                echo '<option>';
                echo $row["nombre"];
                echo '</option>';
              }
           } 
        else
          echo "0 results";

    $conn->close(); 
       
       ?>
      </select>

    </div>
    <br><button type="submit" name="filtro" class="btn btn-primary">Filtrar</button>
 </div>
</form>

<?php
   if(isset($_POST["filtro"]))
   {

    $filtro=$_POST["select"];
   //  echo $filtro;
     $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  comentarios WHERE nombre_user='$filtro' ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Los mensajes de ".$filtro."</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>Nombre</th>';
            echo '<th>Fecha</th>';
            echo '<th>Comentario</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["nombre_user"]."</td><td>".$row["Fecha"]."</td> <td>".$row["Comentario"]."</td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
        echo "0 results";


    $conn->close(); 

   }
?>
<hr>
<div class="form-group"><br>
<form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" > 
<div class ="fecha_filtro">
  <label for="usr">Buscar</label>
  <input type="text" class="form-control" id="usr" name="txt_buscar"><br>
  </div>
  <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>

  </form> 
</div>


<?php
   if(isset($_POST["buscar"]))
   {

    $filtro=$_POST["txt_buscar"];
    //echo $filtro;
     $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  comentarios WHERE Comentario LIKE '%" . $filtro."%' ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   //var_dump($result);

    if ($result->num_rows > 0)
     {
         echo "<h3>Los mensajes de:  ".$filtro."</h3>";
            echo '<div class="container">';
            echo '<div class="table-responsive"> ';
            echo ' <table class="table">';
            echo ' <thead>';
            echo ' <tr>';
            echo '<th>Nombre</th>';
            echo '<th>Fecha</th>';
            echo '<th>Comentario</th>';
            echo ' </tr>';
            echo '</thead>';
            echo '<tbody>';
           while($row = $result->fetch_assoc())
           {

             echo "<tr><td>".$row["nombre_user"]."</td><td>".$row["Fecha"]."</td> <td>".$row["Comentario"]."</td></tr>";     
           }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
         
     } 
    else
    {
       echo ' <div class="panel panel-success">
                 <div class="panel-heading">0 resultados</div>
                 <div class="panel-body"></div>
                 </div>';
       // echo "0 results";
    }


    $conn->close(); 

   
   }

?>
<hr>


  <div class="form-group"><br>
<form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" > 

<div class ="fecha_filtro">
     <label for="usr">Filtrar por fecha desde</label>
     <input type="text" class="form-control" id="usr" name="txt_fech_filtro_desde"><br>
</div>
<div class ="fecha_filtro">
     <label for="usr">Filtrar por fecha hasta</label>
     <input type="text" class="form-control" id="usr" name="txt_fech_filtro_hasta"><br>
</div>
  <button type="submit" name="fech_filtro" class="btn btn-primary">Filtrar</button>

  </form> 
</div>

  <?php

    if(isset($_POST["fech_filtro"]))
    {
      
     $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    $fecha1=$_POST["txt_fech_filtro_desde"];
    $fecha2=$_POST["txt_fech_filtro_hasta"]." 23:59:59";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

   // $sql=  "SELECT  nombre_user,Fecha,Comentario  FROM  comentarios WHERE Fecha BETWEEN'$fecha1' AND '$fecha2' ";
   $sql=  "SELECT  nombre_user,Fecha,Comentario  FROM  comentarios  WHERE Fecha >='$fecha1' AND Fecha <='$fecha2' ";
   // echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);
    if ($result->num_rows > 0)
     {
      echo "<h3>Todos los mensajes desde ".$fecha1." hasta ".$fecha2."</h3>";
      echo '<div class="container">';
      echo'<div class="table-responsive"> ';
      echo ' <table class="table">';
      echo ' <thead>';
      echo ' <tr>';
      echo '<th>Nombre</th>';
      echo '<th>Fecha</th>';
      echo '<th>Comentario</th>';
      echo' </tr>';
      echo '</thead>';
      echo '<tbody>';

      while($row = $result->fetch_assoc())
         {
            echo "<tr><td>".$row["nombre_user"]."</td><td>".$row["Fecha"]."</td> <td>".$row["Comentario"]."</td></tr>";
        }

      echo '</tbody>';
      echo '</table>';
      echo '</div>';
      echo '</div>';

    } 
    else
        { echo ' <div class="panel panel-success">
                 <div class="panel-heading">0 resultados</div>
                 <div class="panel-body"></div>
                 </div>';}


    $conn->close(); 

    }
   
  ?>
<hr>

   <?php

     $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT id_user ,Comentario , Fecha , nombre_user FROM  comentarios ";
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);
    if ($result->num_rows > 0)
     {
      echo "<h3>Todos los mensajes</h3>";
      echo '<div class="container">';
      echo'<div class="table-responsive"> ';
      echo ' <table class="table">';
      echo ' <thead>';
      echo ' <tr>';
      echo '<th>Nombre</th>';
      echo '<th>Fecha</th>';
      echo '<th>Comentario</th>';
      echo' </tr>';
      echo '</thead>';
      echo '<tbody>';

      while($row = $result->fetch_assoc())
         {
            echo "<tr><td>".$row["nombre_user"]."</td><td>".$row["Fecha"]."</td> <td>".$row["Comentario"]."</td></tr>";
        }

      echo '</tbody>';
      echo '</table>';
      echo '</div>';
      echo '</div>';

    } 
    else
        echo "0 results";


    $conn->close(); 

    ?> 





</div>








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