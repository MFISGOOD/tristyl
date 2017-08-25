<?php
error_reporting ( E_ALL );

require_once ('Table.php');
/**
 * untitledModel - MDB.php
 *
 * $Id$
 *
 * This file is part of TristylModel.
 *
 * @author Mohamed
 * @since 01/08/2017
 * @version 1.0
 *         
 */

if (0 > version_compare ( PHP_VERSION, '5' )) {
	die ( 'This file was generated for PHP 5' );
}

/**
 * Short description of class Achat
 *
 * @access public
 * @author Mohamed
 * @since 01/08/2017
 * @version 1.0
 *         
 */
class MDB {
	/**
	 *
	 * @var String
	 */
	private $dsn = "odbc:connectionPos";
	// --- ATTRIBUTES ---
	/**
	 *
	 * @var PDO
	 */
	private $pdo = null;
	
	/**
	 * @return PDO
	 */
	public function getDriver(){
		return $this->pdo;
	}
	/**
	 *
	 * @var PDOStatement
	 */
	private $select = null;
	
	/**
	 *
	 * @var PDOStatement
	 */
	private $selectById = null;
	/**
	 *
	 * @var Fournisseurs
	 */
	public $fournisseurs = null;
	/**
	 *
	 * @var Achat
	 */
	public $achat = null;
	/**
	 *
	 * @var int
	 */
	private $total = null;
	
	// --- OPERATIONS ---
	/**
	 *
	 * @throws PDOException
	 */
	public function __construct() {
		// error control
		try {
			$this->pdo = new PDO ( $this->dsn, "", "" );
			$this->pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$this->achat = new Achat ( $this->pdo );
			$this->fournisseurs = new Fournisseurs ( $this->pdo );
			$this->selectById = $this->pdo->prepare ( $this->getSqlSelctAll () . " WHERE {$this->achat->name}.ID=:idEdit" );
		} catch ( PDOException $e ) {
			die ( "MDB __construct  ! : " . $e->getMessage () );
			throw new PDOException ( "MDB __construct \n: " . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
	}
	/**
	 * @param $value
	 * @return mixed
	 */
	public static function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
		$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c","'");
		$replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b","\'");
		$result = str_replace($escapers, $replacements, $value);
		return $result;
	}
	
	/**
	 *
	 * @param String $where        	
	 * @param String $sort        	
	 * @param int $start        	
	 * @param int $limit        	
	 * @throws PDOException
	 * @return Ambigous <multitype:, multitype:Ambigous <> >
	 */
	public function selectPage($where, $sort, $start, $limit) {
		$sql = $this->getSqlSelctAll () . $where . " " . $sort;
		try {
			return $this->execute ( $sql, $start, $limit );
		} catch ( PDOException $e ) {
			die ( "MDB seletPage : \n  " . $e->getMessage () );
			throw new PDOException ( "MDB seletPage : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
	}
	
	/**
	 *
	 * @param VirtuelRow $virtuelRow        	
	 */
	public function addRow($virtuelRow) {
		if ($virtuelRow == null || count ( $virtuelRow->data ) != VirtuelRow::$colums) {
			throw new PDOException ( "MDB : virtuelRow is null !", "-1", null );
		} else {
			$virtuelRow->data [VirtuelRow::$nomFournisseur] = $this->fournisseurs->getIdByname ( $virtuelRow->data [VirtuelRow::$nomFournisseur] );
			$this->achat->insert ( new RowAchat ( array_values ( $virtuelRow->data ) ) );
		}
	}
	/**
	 *
	 * @param VirtuelRow $virtuelRow        	
	 */
	public function updateRow($virtuelRow) {
		if ($virtuelRow == null || count ( $virtuelRow->data ) != VirtuelRow::$colums) {
			throw new PDOException ( "MDB : virtuelRow is null !", "-1", null );
		} else {
			$virtuelRow->data [VirtuelRow::$nomFournisseur] = $this->fournisseurs->getIdByname ( $virtuelRow->data [VirtuelRow::$nomFournisseur] );
			$this->achat->update ( new RowAchat ( array_values ( $virtuelRow->data ) ) );
		}
	}
	/**
	 *
	 * @param array<int> $iDs        	
	 */
	public function deleteRow($iDs) {
		if ($iDs == null) {
			throw new PDOException ( "MDB : deleteRow [iDs] is null !", "-1", null );
		}
		$afected = 0;
		for($i = 0; $i < count ( $iDs ); ++ $i) {
			$fp = fopen ( "monfichier.txt", "wb" );
			try {
				if ($this->achat->delete ( $iDs [$i] )) {
					++ $afected;
				}
			} catch ( PDOException $e ) {
			}
		}
		return $afected;
		// or ID IN $iDs
	}
	
	/**
	 *
	 * @return number
	 */
	public function getTotal() {
		return $this->total;
	}
	public function getDataById($idEdit) {
		// error don't forget that
		$this->selectById->execute ( array (
				':idEdit' => $idEdit 
		) );
		$data = $this->selectById->fetchAll ( PDO::FETCH_ASSOC );
		if ($data != null && count ( $data ) > 0) {
			return new VirtuelRow ( $data [0] );
		}else{
			return null;
		}
	}
	/**
	 *
	 * @return string
	 */
	public function getSqlSelctAll() {
		$sql = "SELECT ";
		$sep = " ";
		for($i = 0; $i < count ( RowAchat::$struct ); ++ $i) {
			if ($i < count ( RowAchat::$struct ) - 1) {
				$sep = ",";
			} else {
				$sep = " ";
			}
			if (RowAchat::$struct [$i] != Achat::$foreignkey) {
				$sql .= "{$this->achat->name}." . RowAchat::$struct [$i] . $sep;
			} else {
				$sql .= "{$this->fournisseurs->name}." . "NomFournisseur" . $sep;
			}
		}
		$primarykey = Fournisseurs::$primarykey;
		$foreignkey = Achat::$foreignkey;
		
		$sql .= " FROM ({$this->achat->name}  INNER JOIN {$this->fournisseurs->name} ON {$this->achat->name}.{$foreignkey} = {$this->fournisseurs->name}.{$primarykey}) ";
		return $sql;
	}
	private function execute($query, $start, $limit) {
		// $result est de type PDOstatment
		$result = $this->pdo->query ( $query );
		$data = $result->fetchAll ( PDO::FETCH_NUM );
		$return = array ();
		$this->total = count ( $data );
		$j = 0;
		for($i = $start; $i < $limit; ++ $i) {
			if ($i < $this->total) {
				$return [$j ++] = $data [$i];
			} else {
				return $return;
			}
		}
		return $return;
	}
} /* end MDB */
class VirtuelRow {
	static $colums = 11;
	static $id = 'Achat.ID';
	static $numFacFour = 'Achat.NumFacFour'; // Numï¿½ro de facture fournisseur
	static $dateFac = 'Achat.DateFac'; // Date facture
	static $numDocComp = 'Achat.NumDocComp'; // Numï¿½ro document comptable
	static $montant = 'Achat.Montant'; // Montant facture
	static $datePayement = 'Achat.DatePayement'; // Date de paiement
	static $dateEcheance = 'Achat.DateEcheance'; // Date d'ï¿½chï¿½ance
	static $ristourne = 'Achat.Ristourne'; // Ristourne
	static $remarque = 'Achat.Remarque';
	static $nomFournisseur = 'Fournisseurs.NomFournisseur'; // Fournisseur
	static $montantPaye = 'Achat.MontantPaye';
	static $struct = array (
			0 => 'Achat.ID',
			1 => 'Achat.NumFacFour', // Numï¿½ro de facture fournisseur
			2 => 'Achat.DateFac', // Date facture
			3 => 'Achat.NumDocComp', // Numï¿½ro document comptable
			4 => 'Achat.Montant', // Montant facture
			5 => 'Achat.DatePayement', // Date de paiement
			6 => 'Achat.DateEcheance', // Date d'ï¿½chï¿½ance
			7 => 'Achat.Ristourne', // Ristourne
			8 => 'Achat.Remarque',
			9 => 'Fournisseurs.NomFournisseur', // Fournisseur
			10 => 'Achat.MontantPaye' 
	);
	static $result_line = array (
			0 => 'ID',
			1 => 'NumFacFour',
			2 => 'DateFac',
			3 => 'NumDocComp',
			4 => 'Montant',
			5 => 'DatePayement',
			6 => 'DateEcheance',
			7 => 'Ristourne',
			8 => 'Remarque',
			9 => 'NomFournisseur',
			10 => 'MontantPaye' 
	);
	public $data = array ();
	/*
	 * public $struct = array ( 'Achat.ID' => 'Achat.ID', 'Achat.NumFacFour' => 'Achat.NumFacFour', // Numï¿½ro de facture fournisseur 'Achat.DateFac' => 'Achat.DateFac', // Date facture 'Achat.NumDocComp' => 'Achat.NumDocComp', // Numï¿½ro document comptable 'Achat.Montant' => 'Achat.Montant', // Montant facture 'Achat.DatePayement' => 'Achat.DatePayement', // Date de paiement 'Achat.DateEcheance' => 'Achat.DateEcheance', // Date d'ï¿½chï¿½ance 'Achat.Ristourne' => 'Achat.Ristourne', // Ristourne 'Achat.Remarque' => 'Achat.Remarque', 'Fournisseurs.NomFournisseur' => 'Fournisseurs.NomFournisseur', // Fournisseur 'Achat.MontantPaye' => 'Achat.MontantPaye' );
	 */
	/**
	 *
	 * @param array $virtuelRow        	
	 */
	public function __construct($virtuelRow) {
		if ($virtuelRow == null || count ( $virtuelRow ) != VirtuelRow::$colums) {
			throw new PDOException ( "VirtuelRow : array virtuelRow is not correct !", "-1", null );
		}
		for($i = 0; $i < VirtuelRow::$colums; ++ $i) {
			$this->data [VirtuelRow::$struct [$i]] = ($virtuelRow [VirtuelRow::$result_line [$i]]);
		}
	}
	
	
}

//$mdb = new MDB ();
// print_r ( $mdb->selectPage ( "", "", 1, 248 ) );
// print_r ( $mdb->fournisseurs->getNamesAndIds(true) ); // $ar=array(0,2010,"2007-01-6",0,58,"2007-01-6","2007-01-6",0,"salut","Meyer",59); //$mdb->addRow(new VirtuelRow($ar)); //print_r($mdb->fournisseurs->getNamesAndIds(true));
// print_r ( $mdb->achat->getMontantPayeOrPages ( 6, 2010, 5, true ) );
// echo$mdb->getSqlSelctAll();
// echo $mdb->achat->getLastInsert();
//echo $mdb->fournisseurs->getIdByname("Impôts/taxe régionale in dépendants et entreprises");
?>