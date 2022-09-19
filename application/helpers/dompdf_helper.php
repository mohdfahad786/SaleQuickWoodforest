<?php defined('BASEPATH') OR exit('No direct script access allowed');
	function create_pdf($pdf_html='')
	{
		$dir = dirname(__FILE__);
		require_once($dir.'/dompdf/dompdf_config.inc.php');
		$dompdf = new DOMPDF(); // Create new instance of dompdf
		$dompdf->load_html($pdf_html); // Load the html
		$dompdf->render(); // Parse the html, convert to PDF
		$pdf_content = $dompdf->output(); // Put contents of pdf into variable for later
		$handle = fopen('file.pdf', 'w');
		fwrite($handle, $pdf_content);
		fclose($handle);
		return $pdf_content;
	}
?>