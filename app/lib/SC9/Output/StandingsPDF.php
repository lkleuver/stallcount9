<?php 

class SC9_Output_StandingsPDF extends FPDF_fpdf{
	
	
	public $standings;
	public $roundRank;
	
	public $_w;
	
	public $startRank = 0;
	public $endRank = 0;
	public $perPage = 21;
	public $divisionName = "";
	
	public function __construct($standings, $roundRank, $divisionName) {
		$this->standings = $standings;
		$this->roundRank = $roundRank;
		$this->divisionName = strtoupper($divisionName);
		
		$this->_w = array(30,  220,    30,      30,   30,    30,       30);
		
		parent::__construct("L", "mm", "A3");
		
		
		$this->startRank = 1;
		$this->endRank = $this->startRank + $this->perPage - 1;
		
		$this->SetMargins(10,10,10);
		$this->AddPage();
		
		
		
		
		$this->table();
	}
	
	
	
	public function Header() {
		$this->SetFont('Helvetica','B',28);
		$this->SetTextColor(128, 128 ,128);
		$this->Cell(300,30,$this->divisionName.' - STANDINGS AFTER ROUND '.$this->roundRank, 0, 0, 'L');
		$this->Cell(100, 30, 'Rank ' .$this->startRank .' - '.$this->endRank, 0, 0, 'R');
		
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
		
		$header = array("#", "Team", "Games", "VP", "OVP", "Margin", "GF");
		for($i = 0; $i <count($header); $i++) {
			$this->Cell($w[$i], 7, $header[$i], 1,0, 'C', true);
		}
		$this->Ln();
	}
	
	public function table() {
		$w = $this->_w;
		

		$cellHeight = 10;

		
		
		$i = 0;
		$x = 0;
		$y = 0;
		foreach($this->standings as $standing) {
    		$fill = false;
    		$this->SetFillColor(234, 234, 234);
    		$this->SetFont('Helvetica','B',14);
    		
    		$y = 0;
    		foreach($standing as $team) {
    			$this->Cell($w[0], $cellHeight, " " .$team["rank"], "LR", 0, "L", $fill);
				$this->Cell($w[1], $cellHeight, "   ".$team["name"], "LR", 0, "L", $fill);
				$this->Cell($w[2], $cellHeight, "   ".$team["games"], "LR", 0, "L", $fill);
				$this->Cell($w[3], $cellHeight, "   ".$team["vp"], "LR", 0, "L", $fill);
				$this->Cell($w[4], $cellHeight, "   ".$team["opp_vp"], "LR", 0, "L", $fill);
				$this->Cell($w[5], $cellHeight, "   ".$team["margin"], "LR", 0, "L", $fill);
				$this->Cell($w[6], $cellHeight, "   ".$team["scored"], "LR", 0, "L", $fill);
				
				
				$fill = !$fill;
				$i++;
				
				if($y < count($standing) - 1 && $x < count($this->standings)) {
					if($i >= $this->perPage) {
						$i = 0;
						$this->startRank = $this->endRank + 1;
						$this->endRank = $this->startRank + $this->perPage - 1;
						
						$this->AddPage();
					}else{
						$this->Ln();
					}
				}
				$y++;
    		}
    		
    		$this->Ln();
    		$x++;
		}
	}
	
	
}