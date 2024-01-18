
<?php

require('db_conn.php');

$connection = new DatabaseConnection();

include_once("fpdf184/fpdf.php");

class PDF extends FPDF
{

	function Header()
	{

		$this-> Image('imgs/logo2.png', 80, 10, 50);
		$this->Ln(30);
		$this->SetFont('Helvetica', 'B', 16);
		$this->SetTextColor(211,110,110);
		$this->Cell(0, 0, 'AURORA FLORALS',0,0,'C');
		$this->Ln(10);
		$this->SetFont('Helvetica', 'B', 15);
		$this->Cell(0, 0, 'ORDER INVOICE',0,0,'C');
		
		$this->Ln(20);
	}

	
	function Footer()
	{
		$this->setY(-25); 
		$this->SetTextColor(27, 53, 79);
		$this->SetFont('Helvetica', '', 10);
		$this->Ln(3);
		$this->Cell(60, 10, '299, Doon Valley Drive, Kitchener, ON',0,0,'C');
		$this->Cell(60, 10, 'auroraflorals@gmail.com',0,0,'C'); 
		$this->Cell(60, 10, '+1 656 999 2036',0,1,'C');
		$this->SetFont('Helvetica', 'I', 8);
		$this->Ln(3);
		$this->Cell(0, 0, 'Page'.$this->PageNo(),0,0,'C');  
	}
	
}


$customer_idparm = $_GET['id'];
$order_idparm = $_GET['order_id'];

$customerData = $connection->get_customer_byId($customer_idparm);
					
$orderresult = $connection->get_order_by_ids($customer_idparm, $order_idparm);
										
$orderProductresult = $connection->get_order_details_products($customer_idparm, $order_idparm);



$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Helvetica','B',12);

$pdf->SetMargins('20', '20', '40');

		if ($customerData->num_rows > 0) {
			
			while($row = $customerData->fetch_assoc()) {
				$customer_name = $row["name"] ?? '';
				$customer_address = $row["address"] ?? '';
				$customer_phn = $row["phone_num"] ?? '';
				$customer_mail = $row["email_address"] ?? '';

			}
		}

		if ($orderresult->num_rows > 0) {
			
			while($row = $orderresult->fetch_assoc()) {
				$order_date = $row["order_date"] ?? '';
				$total_order_price = $row["total_price"] ?? '';
				$total_order_price_withtax = $total_order_price + ($total_order_price*0.13) ;
			}
		}
		

		$product_heading = array('Product name', 'Unit price', 'Quantity', 'Amount');
		

		$pdf->Ln(2);
		$pdf->SetDrawColor(0, 171, 102);
		$pdf->SetTextColor(27, 53, 79);
		$pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(35, 10, 'Invoice Number:', 0); 
		$pdf->SetFont('Helvetica', '', 12); 

		$pdf->SetTextColor(43, 83, 124);
		$pdf->Cell(55, 10, $order_idparm, 0); 

		$pdf->SetTextColor(27, 53, 79);
		$pdf->SetFont('Helvetica', 'B', 12);
		$pdf->Cell(35, 10, 'Order Date:', 0, 0, 'R'); 
		$pdf->SetFont('Helvetica', '', 12); 

		$pdf->SetTextColor(43, 83, 124);
		$pdf->Cell(15, 10, $order_date, 0, 1);
		
		$pdf->SetTextColor(27, 53, 79);
		$pdf->SetFont('Helvetica', 'B', 12);
		$pdf->Cell(12, 10, 'Billed to:', 0, 0);
		$pdf->Ln(5); 
		$pdf->SetFont('Helvetica', '', 12); 

		$pdf->SetTextColor(43, 83, 124);
		$pdf->Cell(12, 10, $customer_name, 0, 0);
		$pdf->Ln(5);
		$pdf->Cell(12, 10, $customer_address, 0, 0);
		$pdf->Ln(5);
		$pdf->Cell(12, 10, $customer_phn, 0, 0);
		$pdf->Ln(5);
		$pdf->Cell(12, 10, $customer_mail, 0, 1);
		$pdf->Ln(5);
		
		$pdf->SetTextColor(27, 53, 79);
		$pdf->SetFont('Helvetica', 'B', 12);
		$pdf->Cell(70, 13, 'Product', 1, 0, 'C');  $pdf->Cell(30, 13, 'Unit price', 1, 0, 'C');  $pdf->Cell(30, 13, 'Quantity', 1, 0, 'C');  $pdf->Cell(40, 13, 'Total Price', 1, 1, 'C');
	

		$pdf->SetTextColor(43, 83, 124);
		foreach($orderProductresult as $row)
		{
			$pdf->SetFont('Helvetica', '', 11);
			$pdf->Cell(70, 10, $row["name"], 1, 0, 'C');  $pdf->Cell(30, 10, $row["unit_price"], 1, 0, 'C');  $pdf->Cell(30, 10, $row["quantity"], 1, 0, 'C');  $pdf->Cell(40, 10, "$".$row["total_price"], 1, 1, 'C');
			
		}

		$pdf->SetTextColor(27, 53, 79);
		$pdf->SetFont('Helvetica', 'B', 12);
		$pdf->Cell(140, 10, 'Subtotal:', 0, 0, 'R');  $pdf->Cell(30, 10, "$".$total_order_price, 0, 1, 'R'); 
		$pdf->Cell(140, 10, 'HST Tax:', 0, 0, 'R'); $pdf->Cell(30, 10, '13%', 0, 1, 'R'); 

		$pdf->SetFont('Helvetica', 'B', 15);
		$pdf->SetFillColor(0, 171, 102);
		$pdf->SetTextColor(163, 0, 41);
		$pdf->Cell(140, 10, 'Invoice total:', 0, 0, 'R');  $pdf->Cell(30, 10, "$".$total_order_price_withtax, 0, 1, 'R');
		
		
$pdf->Output();
?>
