<?php
require_once ('../mdb/MDB.php');
header ( "Content-type: text/x-json ; charset=ISO-8859-1" );

try {
	$achat = new MDB ();
	if (isset ( $_GET ['idEdit'] )) {
		$virtuelRow = $achat->getDataById ($_GET ['idEdit']);
		if ($virtuelRow != null ) {
			$json = "";
			$json .= "{\n";
			$i;
			for($i=0;$i<$virtuelRow::$colums -1;++$i){
				$val=MDB::escapeJsonString($virtuelRow->data[$virtuelRow::$struct[$i]]);
				$json .= "\"{$virtuelRow::$struct[$i]}\" : \"{$val}\" ,\n";
			} 
			$val=MDB::escapeJsonString($virtuelRow->data[$virtuelRow::$struct[$i]]);
				$json .= "\"{$virtuelRow::$struct[$i]}\" : \"{$val}\"\n";
				$json .= "}\n";
				
				
			echo $json;
		} else {
			echo json_encode ( array (
					VirtuelRow::$id => '' 
			) );
		}
	} else {
		echo json_encode ( array (
				VirtuelRow::$id => '' 
		) );
	}
} catch ( PDOException $ex ) {
	echo json_encode ( array (
			VirtuelRow::$id => '' 
	) );
}
?>