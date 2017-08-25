<?php
require_once ('../mdb/MDB.php');
header ( "Content-type: text/x-json ; charset=ISO-8859-1" );

try {
	$achat = new MDB ();
	
	if (isset ( $_GET ['lastId'] )) {
		echo json_encode ( array (
				'lastId' => $achat->achat->getLastInsert () +1 
		) );
		exit ();
	}
	
	if (isset ( $_GET ['add'] )) {
		$_GET ['NumFournisseur'] = $achat->fournisseurs->getIdByname(( $_GET ['NumFournisseur']) );
		//the first parm of $_GET is  $_GET ['add']
		$rowAchat = new RowAchat ( array_values (  array_values ( array_slice($_GET,1,count($_GET)-1 )) ) );
		$achat->achat->insert ( $rowAchat );
		
		echo json_encode ( array (
				'lastId' => $achat->achat->getLastInsert ()+1 
		) );
	}
	if (isset ( $_GET ['update'] )) {
		
		$_GET ['NumFournisseur'] = $achat->fournisseurs->getIdByname ( $_GET ['NumFournisseur'] );
		//the first parm of $_GET is  $_GET ['update'] 
		$rowAchat = new RowAchat ( array_values ( array_slice($_GET,1,count($_GET)-1 )));
		$achat->achat->update( $rowAchat );
		echo json_encode ( array (
				'lastId' => 'yes'
		) );
	}
} catch ( PDOException $ex ) {
	echo $ex->getMessage ();
	echo json_encode ( array (
			'lastId' => "null" 
	) );
}

?>
