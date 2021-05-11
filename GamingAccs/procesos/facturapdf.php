<?php
  require('pdf/fpdf/fpdf.php');
  include_once('db.php');
  session_start();

  $id_factura = isset( $_GET['factura_id'] ) ? $_GET['factura_id'] : null;

  class PDF extends FPDF
  {
    // Cabecera de la página
    function Header()
    {
      // Logo
      $this->Image('../img/logo.png',10,6,20);
      // Fuente: Arial bold 18
      $this->SetFont('Arial','B',18);
      // Se mueve a la derecha
      $this->Cell(70);
      // Titulo
      $this->Cell(50,10,'Gaming Accs',0,1,'C');
      // Se mueve a la derecha
      $this->Cell(70);
      $this->Cell(50,10,'Factura de Compra',0,0,'C');
      // Salto de Linea
      $this->Ln(20);
    }
    
    // Pie de página
    function Footer()
    {
      // Se posiciona a 1.5cm del final
      $this->SetY(-15);
      // Fuente: Arial italic 8
      $this->SetFont('Arial','I',8);
      // Número de Página
      $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
  }

  $consulta_cliente = "SELECT * from personas where id_persona = '".$_SESSION['id_persona']."'";
  $res_cliente = mysqli_query( $conexion, $consulta_cliente ) or die ( "Error en la consulta: ".$consulta_cliente);

  $consulta_prods = "SELECT * from factura where id_factura = '$id_factura'";
  $res_prods = mysqli_query( $conexion, $consulta_prods ) or die ( "Error en la consulta: ".$consulta_prods);

  
  // Creacion del objeto de la clase heredada
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',12);

  $pdf->Cell(70);
  $pdf->Cell(50, 10, 'Felicitaciones por tu compra Gamer! Aqui tienes un resumen de ella para ti!', 0, 1, 'C');
  $pdf->Cell(191, 0, "", 1, 1, 'C', 0);
  
  
  $pdf->Ln(10);

  while($col_cliente = $res_cliente->fetch_assoc())
  {
    $pdf->Cell(40, 10, 'Cliente: '.$col_cliente['nombres'], 0, 1, 'L', 0);
    $pdf->Cell(40, 10, 'Cedula: '.$col_cliente['cedula'], 0, 1, 'L', 0);
  }

  $pdf->Ln(10);

  $pdf->Cell(30, 10, 'ID', 1, 0, 'C', 0);
  // $pdf->Cell(80, 10, 'Descripcion', 1, 0, 'C', 0);
  $pdf->Cell(40, 10, 'Total', 1, 0, 'C', 0);
  $pdf->Cell(40, 10, 'Estado', 1, 1, 'C', 0);
  

  while($col_prods = $res_prods->fetch_assoc())
  {
    $pdf->Cell(30, 10, $col_prods['id_factura'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $col_prods['total'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $col_prods['estado'], 1, 1, 'C', 0);


    $pdf->Ln(10);
    $pdf->Cell(80, 10, 'Descripcion:', 0, 1, 'L', 0);
    $pdf->MultiCell(250, 5, $col_prods['descripcion'], 'L');
  }

  $pdf->Output();

?>

