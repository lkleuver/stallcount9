<?php 

class SC9_Output_ResultsPDF extends FPDF_fpdf{
	
	
	public $rounds;
	public $roundRank;
	
	public $_w;
	
	public $perPage = 21;
	public $divisionName = "";
	
	
	public function __construct($rounds, $roundRank, $divisionName) {
		$this->rounds = $rounds;
		$this->roundRank = $roundRank;
		$this->divisionName = strtoupper($divisionName);
		
		$this->_w = array(30, 40, 145, 145, 40);
		
		parent::__construct("L", "mm", "A3");
		

		
		$this->SetMargins(10,10,10);
		$this->AddPage();
		
		
		
		
		$this->table();
	}
	
	
	
	public function Header() {
		$this->SetFont('Helvetica','B',28);
		$this->SetTextColor(128, 128 ,128);
		$this->Cell(300,30,$this->divisionName.' - RESULTS FOR ROUND '.$this->roundRank, 0, 0, 'L');

		
		$this->Ln();
		$this->tableHeader();
	}

	public function Footer() {
		$this->SetFillColor(0,0,0);
		$this->Cell(array_sum($this->_w), 7, "", 1,0,'C', true);
	}	

	public function tableHeader() {
		$w = $this->_w;
		
		$this->SetFont('Helvetica','',14);
		$this->SetTextColor(255, 255, 255);
		$this->SetFillColor(0,0,0);
		
		$header = array("Field", "Time", "Team", "Team", "Result");
		for($i = 0; $i <count($header); $i++) {
			$this->Cell($w[$i], 7, $header[$i], 1,0, 'C', true);
		}
		$this->Ln();
	}
	
	public function table() {
		$w = $this->_w;
		
		$cellHeight = 10;
		
    		$i = 0;	
		foreach($this->rounds as $round) {
    		
    		$fill = false;
    		$this->SetFillColor(234, 234, 234);
    		

    		foreach($round->Matches as $match) {
    			$this->SetFont('Helvetica','',16);
    			$this->Cell($w[0], $cellHeight, " " .$match->getFieldName(), "LR", 0, "L", $fill);
				$this->Cell($w[1], $cellHeight, $match->timeFormat(), "LR", 0, "C", $fill);

				$this->SetFont('Helvetica','B',16);
				$this->Cell($w[2], $cellHeight, "  ".$match->getHomeName(), "LR", 0, "L", $fill);
				$this->Cell($w[3], $cellHeight, "  ".$match->getAwayName(), "LR", 0, "L", $fill);
				
				
				$this->SetFont('Helvetica','B',16);
				$this->Cell($w[4], $cellHeight, "  ".$match->printResult(), "LR", 0, "L", $fill);
				
				
				$fill = !$fill;
				$this->Ln();
    		}
			if($i < count($this->rounds) - 1) {    		
	    		$this->Ln();
			}
    		
    		$i++;
		}
    	
	}
	
	
}