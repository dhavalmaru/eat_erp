<?php
	use Smalot\PdfParser\Parser;

	require_once('pdfparser/src/Smalot/PdfParser/Parser.php'); 

	// $parser = new pdfparser\src\Smalot\PdfParser\Parser();

	$parser = new Parser();
	$pdf = $parser->parseFile('sample.pdf');  
	$text = $pdf->getText();
	echo $text;//all text from mypdf.pdf
?>