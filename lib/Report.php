<?php
  require_once('../view/assets/mpdf60/mpdf.php');

  class Report {
		private $css;
		private $titulo;
		private $header;
		private $content;
		private $pdf;
		
		public function setCss($file) {
			if (file_exists($file)) {
				$this->css = file_get_contents($file);
			}
		}
		
		public function setContent($html) {
			$this->content = $html;
		}
		
		public function buildPDF() {
			$this->pdf = new mPDF('utf-8', 'A4-L');
			$this->pdf->WriteHTML($this->css, 1);
			$this->pdf->WriteHTML($this->content, 2);
		}
		
		public function displayPDF($nome = null) {
			$this->pdf->Output($nome, 'I');
		}
	}
?>