<?php
error_reporting ( 0 );
require_once ('../mdb/MDB.php');
$achat = new MDB ();
//
if (isset ( $_POST ['items'] )) {
	$items = rtrim ( $_POST ['items'], "," );
	$total = count ( explode ( ",", $items ) );
	$result = $achat->deleteRow ( explode ( ",", $items ) );
	// / Line 18/19 commented for demo purposes. The MySQL query is not executed in this case. When line 18 and 19 are uncommented, the MySQL query will be executed.
	header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . "GMT" );
	header ( "Cache-Control: no-cache, must-revalidate" );
	header ( "Pragma: no-cache" );
	header ( "Content-type: text/x-json" );
	$json = "";
	$json .= "{\n";
	$json .= "affected: '" . $result . "',\n";
	$json .= "total: $total,\n";
	$json .= "}\n";
	echo $json;
	exit ();
}
//
$page = 1;
$rp = 50;
$sortorder = 'asc';
$sortname = 'Achat.ID';

if (isset ( $_POST ['page'] )) {
	$page = $_POST ['page'];
}
if (isset ( $_POST ['rp'] )) {
	$rp = $_POST ['rp'];
}
if (isset ( $_POST ['sortname'] )) {
	$sortname = $_POST ['sortname'];
	if ($sortname == VirtuelRow::$nomFournisseur) {
		// $sortname="Achat.".Achat::$foreignkey;
	}
}
if (isset ( $_POST ['sortorder'] )) {
	$sortorder = $_POST ['sortorder'];
}

if (! $sortname)
	$sortname = 'Achat.ID';
if (! $sortorder)
	$sortorder = 'asc';

if (! $page)
	$page = 1;
if (! $rp)
	$rp = 10;

$start = (($page - 1) * $rp);

$limit = $rp * $page;

// count records with condition

$where = '';

if (isset ( $_POST ['query'] ) && ($_POST ['query']) != 'mySearch' && $_POST ['query'] != '') {
	$type = $_POST ['qtype'];
	$value = utf8_decode ( $_POST ['query'] );
	
	$where = "WHERE " . $type . " LIKE '%" . $value . "%' ";
} else {
	$where = '';
}

// WHERE NumFournisseur=:numFour AND (year(DateFac)=:year AND month(DateFac)=:month)"
/*
 * if ((isset ( $_POST ['letter_pressed'] ) && $_POST ['letter_pressed'] != '') && (isset ( $_POST ['query'] ) && $_POST ['query'] != '')) { $where = "WHERE `" . $_POST ['qtype'] . "` LIKE '" . $_POST ['letter_pressed'] . "%' "; } if ((isset ( $_POST ['letter_pressed'] ) && $_POST ['letter_pressed'] == '#')&&(isset($_POST ['query']) && $_POST ['query'] != '')) { $where = "WHERE `" . $_POST ['qtype'] . "` REGEXP '[[:digit:]]' "; }
 */

if (isset ( $_POST ['MYSEARCH'] ) && $_POST ['MYSEARCH'] == 'YES') {
	$where = "";
	if (isset ( $_POST ['numFacFour'] ) && $_POST ['numFacFour'] != "") {
		$value = utf8_decode ( $_POST ['numFacFour'] );		
		$where .= "Achat.NumFacFour LIKE '%" . $value . "%' ";
	}
	if (isset ( $_POST ['name'] ) && $_POST ['name'] != "") {
		$iso = ($achat->fournisseurs->getIdByname ( utf8_decode ( $_POST ['name'] ) ));
		if ($where != "") {
			$where .= " AND Achat.NumFournisseur=$iso";	
		}else{
			$where .= " Achat.NumFournisseur=$iso";
		}
			
		
	}
	if (isset ( $_POST ['year'] ) && $_POST ['year'] != "" && is_numeric ( $_POST ['year'] )) {
		if ($where != "") {
			$where .= " AND year(Achat.DateEcheance)={$_POST ['year'] }";
		} else {
			$where .= " year(Achat.DateEcheance)={$_POST ['year']}";
		}
		// Insère le texte « PHP 5 » dans le fichier
	}
	if (isset ( $_POST ['month'] ) && $_POST ['month'] != "" && is_numeric ( $_POST ['month'] )) {
		
		if ($where != "") {
			$where .= " AND  month(Achat.DateEcheance)={$_POST ['month']}";
		} else {
			$where .= " month(Achat.DateEcheance)={$_POST ['month']}";
		}
	}
	if ($where != "") {
		$where = " WHERE $where";
	}
}
$sort = "ORDER BY $sortname $sortorder";

// $sql = "Select * From {$table->name} $where $sort $limit";

$result = $achat->selectPage ( $where, $sort, $start, $limit );
$total = $achat->getTotal ();

header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . "GMT" );
header ( "Cache-Control: no-cache, must-revalidate" );
header ( "Pragma: no-cache" );
header ( "Content-type: text/x-json ; charset=ISO-8859-1" );
$data = array ();
$data ['page'] = $page;
$data ['total'] = $total;
$data ['myTotal'] = $total;
$rows = array ();
$json = "";
$json .= "{\n";
$json .= "page: $page,\n";
$json .= "total: $total,\n";
$json .= "myTotal: $total,\n";
$json .= "rows: [";
$rc = false;
$lines = 0;
if ($result != null) {
	$lines = count ( $result );
}
$line = 0;
while ( $line < $lines ) {
	$myRow = array ();
	$row = $result [$line ++];
	if ($rc)
		$json .= ",";
	$json .= "\n{";
	$json .= "id:'" . $row [0] . "',";
	$myRow ['id'] = $row [0];
	$cell = array ();
	$json .= "cell:['" . $row [0] . "'";
	$cell [] = $row [0];
	$json .= ",'" . MDB::escapeJsonString ( ($row [1]) ) . "'";
	//
	$cell [] = $row [1];
	//
	$json .= ",'" . $row [2] . "'";
	$cell [] = $row [2];
	$json .= ",'" . addslashes ( $row [3] ) . "'";
	$cell [] = $row [3];
	$json .= ",'" . addslashes ( $row [4] ) . "'";
	$cell [] = $row [4];
	$json .= ",'" . addslashes ( $row [5] ) . "'";
	$cell [] = $row [5];
	$json .= ",'" . addslashes ( $row [6] ) . "'";
	$cell [] = $row [6];
	$json .= ",'" . addslashes ( $row [7] ) . "'";
	$cell [] = $row [7];
	$json .= ",'" . MDB::escapeJsonString ( $row [8] ) . "'";
	$cell [] = $row [8];
	$json .= ",'" . MDB::escapeJsonString ( $row [9] ) . "'";
	$cell [] = $row [9];
	$json .= ",'" . addslashes ( $row [10] ) . "']";
	$cell [] = $row [10];
	$myRow ['cell'] = $cell;
	$rows [] = $myRow;
	$json .= "}";
	$rc = true;
}
$data ['rows'] = $rows;
$json .= "]\n";
$json .= "}";
echo $json;

// echo json_encode($data);
// _________________________________________________________
/*
 * $data=array();
 * $data['page']=$page;
 * $data['total']=$total;
 * $data['myTotal']=$total;
 * $rows=array();
 * $json = "";
 * $json .= "{\n";
 * $json .= "page: $page,\n";
 * $json .= "total: $total,\n";
 * $json .= "myTotal: $total,\n";
 * $json .= "rows: [";
 * $rc = false;
 * $lines = 0;
 * if ($result != null) {
 * $lines = count ( $result );
 * }
 * $line = 0;
 * while ( $line < $lines ) {
 * $myRow=array();
 *
 * $row = $result [$line ++];
 * if ($rc)
 * $json .= ",";
 * $json .= "\n{";
 * $json .= "id:'" . $row [0] . "',";
 * $myRow['id']=$row [0];
 * $cell=array();
 * $json .= "cell:['" . $row [0] . "'";
 * $cell[]= $row [0];
 * $json .= ",'" . addslashes ( $row [1] ) . "'";
 * $cell[]= $row [1];
 * $json .= ",'" . addslashes ( $row [2] ) . "'";
 * $cell[]= $row [2];
 * $json .= ",'" . addslashes ( $row [3] ) . "'";
 * $cell[]= $row [3];
 * $json .= ",'" . addslashes ( $row [4] ) . "'";
 * $cell[]= $row [4];
 * $json .= ",'" . addslashes ( $row [5] ) . "'";
 * $cell[]= $row [5];
 * $json .= ",'" . addslashes ( $row [6] ) . "'";
 * $cell[]= $row [6];
 * $json .= ",'" . addslashes ( $row [7] ) . "'";
 * $cell[]= $row [7];
 * $json .= ",'" . addslashes (trim($row [8]) ) . "'";
 * $cell[]= $row [8];
 * $json .= ",'" . addslashes ( $row [9] ) . "'";
 * $cell[]= $row [9];
 * $json .= ",'" . addslashes ( $row [10] ) . "']";
 * $cell[]= $row [10];
 * $myRow['cell']=$cell;
 * $rows[]=$myRow;
 * $json .= "}";
 * $rc = true;
 * }
 * $data['rows']=$rows;
 * $json .= "]\n";
 * $json .= "}";
 * //echo $json;
 * echo json_encode($data);
 */
?>