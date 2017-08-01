<?php
// Start the session
session_start();

?>
<?php
 require('fpdf.php');


if(isset($_POST["registrar"]))
{


   $id=$_POST["id_cliente"];
   $nombre=$_SESSION["user"];
   
     $servername = "localhost";
    $username = "id2418557_rafata";
    $password = "papagal84";
    $dbname = "id2418557_alta";
 
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8") ;
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql=  "SELECT * FROM  comentarios WHERE id_user=$id ";
    //echo $sql;
    //$sql = "SELECT id_user, Comentarios, Fecha, nombre_user FROM comentarios";
    $result = $conn->query($sql);
    
   // var_dump($result);

    if ($result->num_rows > 0)
     {
          class PDF extends FPDF {
                    // Cabecera de página
                    function Header() {
                        // Logo
                        //$this->Image('tv.jpg',10,8,33);
                        // Arial bold 15
                        $this->SetFont('Arial','B',15);
                        // Movernos a la derecha
                        $this->Cell(80);
                        // Título
                        $this->Cell(0,10,'Mensajes de '.$_SESSION["user"],0,0,'L');
                        // Salto de línea
                        $this->Ln(20);
                    }

                    // Pie de página
                    function Footer() {
                        // Posición: a 1,5 cm del final
                        $this->SetY(-15);
                        // Arial italic 8
                        $this->SetFont('Arial','I',8);
                        // Número de página
                        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
                    }
                }    

                $border=0;

                $pdf = new PDF();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',16);
                $pdf->Cell(105,10,utf8_decode('Comentario'),$border,0,'L');
                $pdf->Cell(30,10,'Fecha',$border,0,'L');
                $pdf->Cell(40,10,'',$border,1,'L');
               //$contador=1;
               while($row = $result->fetch_assoc())
               {

                        $pdf->Cell(105,10,utf8_decode($row["Comentario"]),$border,0,'L');
                        $pdf->Cell(30,10,utf8_decode($row["Fecha"]),$border,1,'L');
                    
               }

           $pdf->Output();
          
         
     } 
    else
        echo "0 results";

    $conn->close(); 
 

}
    ?>