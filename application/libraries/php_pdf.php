<?php
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;

require_once('fpdf181/fpdf.php');
require_once('fpdi2/src/autoload.php');
require_once('pdfparser/src/Smalot/PdfParser/Parser.php');

$parser = new Parser();
$pdf = $parser->parseFile('sample.pdf');
$text = $pdf->getText();
// echo $text;

if(isset($text)) {
	if($text!='') {
		$pdf = new FPDI();
		$pdf->setSourceFile('sample.pdf');

		$i = 1;
		while(strpos($text, 'Tax Invoice/Bill of Supply/Cash Memo')!==False) {
			echo $i;
			echo '<br/><br/>';

			$pdf->AddPage();
			$tplIdx = $pdf->importPage($i++);
			$pdf->useTemplate($tplIdx);
			$pdf->SetTextColor(225, 10, 10);

			$textArr = [];
			$y = 240;

			if(strpos($text, 'Invoice Date')!==False) {
				$text = substr($text, strpos($text, 'Invoice Date')+12);
				// echo $text;
				// echo '<br/><br/>';

				if(strpos($text, 'Tax Invoice/Bill of Supply/Cash Memo')!==False) {
					$text2 = substr($text, 0, strpos($text, 'Tax Invoice/Bill of Supply/Cash Memo'));
				} else {
					$text2 = $text;
				}
				// echo $text2;
				// echo '<br/><br/>';
				
				while(strpos($text2, '|')!==False) {
					$text2 = substr($text2, strpos($text2, '|')+1);
					$text2 = trim($text2);
					// echo $text2;
					// echo '<br/><br/>';

					if(strpos($text2, '|')!==False) {
						$text3 = substr($text2, 0, strpos($text2, '|'));
						$y = $y + 12;
					} else {
						$text3 = $text2;
					}
					$text3 = trim($text3);
					echo $text3;
					echo '<br/><br/>';

					// if(strpos($text3, ' ')!==False) {
					// 	$text4 = substr($text3, 0, strpos($text3, ' '));
					// } else if(strpos($text3, '(')!==False) {
					// 	$text4 = substr($text3, 0, strpos($text3, '(')-1);
					// } else {
					// 	$text4 = $text3;
					// }
					if(strlen($text3)>=10){
						$text4 = substr($text3, 0, 10);
					} else {
						$text4 = $text3;
					}

					$text4 = trim($text4);
					echo $text4;
					echo '<br/><br/>';

					$textArr[] = $text4;
				}
			} else {
				$text = substr($text, strpos($text, 'Tax Invoice/Bill of Supply/Cash Memo')+36);
			}

			$pdf->AddPage();
			$tplIdx = $pdf->importPage($i++);
			$pdf->useTemplate($tplIdx);
			$pdf->SetFont('Arial', 'B', '10');
			
			foreach ($textArr as $key => $value) {
				$pdf->SetXY(20, $y);
				$pdf->Write(0, $value);
				$y = $y + 4;
			}

			// if($i==11) {
			// 	break;
			// }
		}

		$pdf->Output('sample_updated.pdf', 'F');
	}
}