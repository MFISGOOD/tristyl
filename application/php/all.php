<?php

require_once ('../mdb/MDB.php');

try {
	$achat = new MDB ();
	$where = "";
	//$_GET['nameFour']=$achat->fournisseurs->getIdByname($_GET['nameFour']);
    //echo $achat->achat->getMontantPayeOrPages($_GET['nameFour'],$_GET['year'], $_GET['month'], false);
	if (isset ( $_GET ['numFacFour'] ) && $_GET ['numFacFour'] != "") {
		$value = utf8_decode ( $_GET ['numFacFour'] );
		$value=str_replace("'", "''", $value);
		$where .= "Achat.NumFacFour LIKE '%" . $value . "%' ";
	}
    if(isset ( $_GET['nameFour'] ) && $_GET ['nameFour'] !="" ){
    	$iso=$achat->fournisseurs->getIdByname(utf8_decode($_GET ['nameFour']));
    	
    if ($where != "") {
			$where .= " AND Achat.NumFournisseur=$iso";	
		}else{
			$where .= " Achat.NumFournisseur=$iso";
		}
    }
    if(isset ( $_GET ['year'] ) && $_GET ['year'] !="" && is_numeric($_GET ['year'])){
    
    	if($where != ""){
    		$where .= " AND year(DateEcheance)={$_GET ['year'] }";
    	}else{
    		$where .= " year(DateEcheance)={$_GET ['year']}";
    	}
    	// Insère le texte « PHP 5 » dans le fichier
    }
    if(isset ( $_GET ['month'] ) && $_GET ['month'] !="" && is_numeric($_GET ['month'])){
    	if($where != ""){
    		$where .= " AND  month(DateEcheance)={$_GET ['month']}";
    	}else{
    		$where .= " month(DateEcheance)={$_GET ['month']}";
    	}
    }
    if($where != ""){
    	$where = " WHERE $where";
    }
   
   echo number_format($achat->achat->getMontantPaye($where), 2, ',', ' '); 
} catch ( PDOException $ex ) {
	echo "error..";
}

?>
