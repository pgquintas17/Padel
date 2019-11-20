<?php

class MSGView {
	
	private $msg;
	private $errs;

	function __construct($msg=null, $errs=null) {
		$this->msg = $msg;
		$this->errs = $errs;
	}

	function render() {
		
		if($this->msg != null) {
			
			?>
			<div class="alert alert-dark" role="alert">
				<h5>
					<?php 
						if(is_array($this->msg)) {
							$toPrint = "";
							foreach ($this->msg as $mensaje) {
								$toPrint = $toPrint . $mensaje . "<br/>";
							}
							echo $toPrint;
						}
						else {
							echo $this->msg;
						}
						
					?>
						
				</h5>
				<hr>
				<p><?php 
						if(is_array($this->errs)) {
							$toPrint = "";
							foreach ($this->errs as $error) {
								$toPrint = $toPrint . $error . "<br/>";
							}
							echo $toPrint;
						}
						else {
							echo $this->errs;
						}
						
					?></p>
			</div>
			<?php
		}
	}

}
?>