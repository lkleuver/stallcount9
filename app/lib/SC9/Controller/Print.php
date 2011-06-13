<?php



class SC9_Controller_Print extends SC9_Controller_Core {
	
	
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
	}
	
	
	
	public function scheduleAction() {
		$stage = Stage::getById($this->request("stageId"));
		$roundRank = $this->request("roundRank");
		
		$rounds = array();
		
		
		foreach($stage->Pools as $pool) {
			$round = Round::getRoundByRank($pool->id, $roundRank, true);
			$rounds[] = $round;
		}
		
		$pdf = new FPDF_fpdf("P", "mm", "A3");
		$pdf->SetMargins(20,20,20);
		$pdf->AddPage();
		
		//HEADER
		$pdf->SetFont('Helvetica','B',48);
		$pdf->SetTextColor(89, 178, 239);
		$pdf->Cell(0,30,'MATCHUPS ROUND '.$roundRank, 0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','',14);
		$pdf->SetTextColor(89, 178, 239);
		
		//TABLE
		//the widths of the columns  field time hometeam awayteam, in mm  
		//total: 297 - 40 - 40 = 217
		$w = array(30, 21, 103, 103);
		$cellHeight = 12;
		//table header
		$header = array("Field", "Time", "Home team", "Away team");
		
		foreach($rounds as $round) {
			for($i = 0; $i <count($header); $i++) {
		        $pdf->Cell($w[$i], 7, $header[$i], 1,0, 'C', true);
			}
    		$pdf->Ln();
    		
    		$fill = false;
    		$pdf->SetFillColor(224,235,255);
    		foreach($round->Matches as $match) {
    			$pdf->SetFont('Helvetica','B',16);
    			$pdf->Cell($w[0], $cellHeight, " " .$match->getFieldName(), "LR", 0, "L", $fill);
				$pdf->Cell($w[1], $cellHeight, $match->timeFormat(), "LR", 0, "C", $fill);

				$pdf->SetFont('Helvetica','',12);
				$pdf->Cell($w[2], $cellHeight, $match->getHomeName(), "LR", 0, "L", $fill);
				$pdf->Cell($w[3], $cellHeight, $match->getAwayName(), "LR", 0, "L", $fill);
				$fill = !$fill;
				$pdf->Ln();
    		}
    		
    		$pdf->Ln();
		}
    	
		$pdf->Output();
	}
	
	
	public function standingsAction() {
		$stage = Stage::getById($this->request("stageId"));
		$roundRank = $this->request("roundRank");
		
		$standings = array();
		foreach($stage->Pools as $pool) {
			$standings[] = $pool->standingsAfterRound($roundRank); 
		}

		$pdf = new FPDF_fpdf("L", "mm", "A3");
		$pdf->SetMargins(10,10,10);
		$pdf->AddPage();
		
		//HEADER
		$pdf->SetFont('Helvetica','B',48);
		$pdf->SetTextColor(89, 178, 239);
		$pdf->Cell(0,30,'STANDINGS ROUND '.$roundRank, 0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','',14);
		$pdf->SetTextColor(89, 178, 239);
		
		//TABLE
		// A3 = 297 × 420
		// margin = 10x10
		// space: 400
		  
		$w = array(30, 130, 30, 30, 30, 30, 30, 30, 30, 30);
		$cellHeight = 10;
		//table header
		$header = array("#", "Team", "Games", "VP", "OVP", "Points", "Margin", "GF", "Wins", "Losses");
		
		foreach($standings as $standing) {
			for($i = 0; $i <count($header); $i++) {
		        $pdf->Cell($w[$i], 7, $header[$i], 1,0, 'C', true);
			}
    		$pdf->Ln();
    		
    		$fill = false;
    		$pdf->SetFillColor(224,235,255);
    		$pdf->SetFont('Helvetica','B',14);
    		foreach($standing as $team) {
    			
    			$team["points"] = "";
    			$team["wins"] = "";
    			$team["losses"] = "";
    			
    			$pdf->Cell($w[0], $cellHeight, " " .$team["rank"], "LR", 0, "L", $fill);
				$pdf->Cell($w[1], $cellHeight, "   ".$team["name"], "LR", 0, "L", $fill);
				$pdf->Cell($w[2], $cellHeight, "   ".$team["games"], "LR", 0, "L", $fill);
				$pdf->Cell($w[3], $cellHeight, "   ".$team["vp"], "LR", 0, "L", $fill);
				$pdf->Cell($w[4], $cellHeight, "   ".$team["opp_vp"], "LR", 0, "L", $fill);
				$pdf->Cell($w[5], $cellHeight, "   ".$team["points"], "LR", 0, "L", $fill);
				$pdf->Cell($w[6], $cellHeight, "   ".$team["margin"], "LR", 0, "L", $fill);
				$pdf->Cell($w[7], $cellHeight, "   ".$team["scored"], "LR", 0, "L", $fill);
				$pdf->Cell($w[8], $cellHeight, "   ".$team["wins"], "LR", 0, "L", $fill);
				$pdf->Cell($w[9], $cellHeight, "   ".$team["losses"], "LR", 0, "L", $fill);
				
				
				$fill = !$fill;
				
				$pdf->Ln();
    		}
    		
    		$pdf->Ln();
		}
    	
		$pdf->Output();
	}
	
}