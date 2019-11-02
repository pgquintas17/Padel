
<?php
    
class SetModel {
	
 	var $n_set; 
    var $punt_pareja1;  
	var $punt_pareja2; 
	

 	function __construct($id_pista,$estado){
        $this->id_pista = $id_pista;
        $this->estado = $estado;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}


}

?>