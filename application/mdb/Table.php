<?php

/* user defined includes */
class RowAchat {
	static $colums = 11;
	static $totalMontantPaye = 'MontantPaye';
	static $struct = array (
			0 => 'ID',
			1 => 'NumFacFour',
			2 => 'DateFac',
			3 => 'NumDocComp',
			4 => 'Montant',
			5 => 'DatePayement',
			6 => 'DateEcheance',
			7 => 'Ristourne',
			8 => 'Remarque',
			9 => 'NumFournisseur',
			10 => 'MontantPaye' 
	);
	static $paramsVars = array (
			'ID' => ':id',
			'NumFacFour' => ':numFacFour',
			'DateFac' => ':dateFac',
			'NumDocComp' => ':numDocComp',
			'Montant' => ':montant',
			'DatePayement' => ':datePayement',
			'DateEcheance' => ':dateEcheance',
			'Ristourne' => ':ristourne',
			'Remarque' => ':remarque',
			'NumFournisseur' => ':numFournisseur',
			'MontantPaye' => ':montantPaye' 
	);
	public $data = array ();
	public function __construct($data) {
		
		if ($data == null || count ( $data ) != RowAchat::$colums ) {
			throw new PDOException ( "RowAchat : array virtuelTable is not correct !", "-1", null );
		}
		
		for($i = 0; $i < RowAchat::$colums; ++ $i) {
			if($i==4 || $i== 7 || $i == 10)
			{
				$this->data [RowAchat::$struct [$i]] =number_format($data [$i], 2, ',','');
			}else{
				$this->data [RowAchat::$struct [$i]] = $data [$i];
			}
			
		}
		
	}
	
	
}
class Achat {
	public $name = 'Achat';
	public $id = 'ID';
	public $numFacFour = 'NumFacFour'; // Numï¿½ro de facture fournisseur
	public $dateFac = 'DateFac'; // Date facture
	public $numDocComp = 'NumDocComp'; // Numï¿½ro document comptable
	public $montant = 'Montant'; // Montant facture
	public $datePayement = 'DatePayement'; // Date de paiement
	public $dateEcheance = 'DateEcheance'; // Date d'ï¿½chï¿½ance
	public $ristourne = 'Ristourne'; // Ristourne
	public $remarque = 'Remarque';
	public $numFournisseur = 'NumFournisseur'; // Fournisseur
	public $montantPaye = 'MontantPaye';
	// foreign key to table Fournisseurs
	static $foreignkey = 'NumFournisseur';
	public $vars = null;
	/**
	 *
	 * @var PDOStatement
	 */
	private $insert = null;
	/**
	 *
	 * @var PDOStatement
	 */
	private $update = null;
	/**
	 *
	 * @var PDOStatement
	 */
	private $delete = null;
	/**
	 *
	 * @var PDOStatement
	 */
	private $totalPaye = null;
	/**
	 *
	 * @var PDOStatement
	 */
	private $select = null;
	/**
	 *
	 * @var PDO
	 */
	protected $driver = null;
	/**
	 *
	 * @var int
	 */
	private $lastinsert;
	/**
	 *
	 * @var int
	 */
	private $total;
	public $struct = array (
			0 => 'ID',
			1 => 'NumFacFour',
			2 => 'DateFac',
			3 => 'NumDocComp',
			4 => 'Montant',
			5 => 'DatePayement',
			6 => 'DateEcheance',
			7 => 'Ristourne',
			8 => 'Remarque',
			9 => 'NumFournisseur',
			10 => 'MontantPaye' 
	);
	public $params = array (
			0 => ':id',
			1 => ':numFacFour',
			2 => ':dateFac',
			3 => ':numDocComp',
			4 => ':montant',
			5 => ':datePayement',
			6 => ':dateEcheance',
			7 => ':ristourne',
			8 => ':remarque',
			9 => ':numFournisseur',
			10 => ':montantPaye' 
	);
	// --- OPERATIONS ---
	/**
	 *
	 * @param PDO $driver        	
	 */
	public function __construct($driver) {
		if ($driver == null) {
			throw new PDOException ( "Achat : driver is null !", "-1", "" );
		}
		$this->driver = $driver;
		try {
			if ($this->driver != null) {
				$this->insert = $this->driver->prepare ( $this->getSqlInsert () );
				$this->update = $this->driver->prepare ( $this->getSqlUpdate () );
				$this->delete = $this->driver->prepare ( $this->getSqlDelete () );
				$this->totalPaye = $this->driver->prepare ( $this->getSqlTotaleMontantPaye () );
				$this->select = $this->driver->prepare ( $this->getSqlTotalePages () );
				
				// select page
				// $this->select_page = $this->driver->prepare ( $this->tableStruct->getSqlSelectPage () );
				$this->update = $this->bindParams ( $this->update );
				$this->insert = $this->bindParams ( $this->insert );
			}
			
			$lastid = $this->driver->query ( $this->getSqlSelectLastInsert() );
			$row = $lastid->fetchAll(PDO::FETCH_NUM);
			$this->lastinsert = $row [0][0];
		} catch ( PDOException $e ) {
			die ( "Achat => __construct ! : " . $e->getMessage () );
			throw new PDOException ( "Achat => __construct : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
		$this->vars = array (
				0 => &$this->id,
				1 => &$this->numFacFour,
				2 => &$this->dateFac,
				3 => &$this->numDocComp,
				4 => &$this->montant,
				5 => &$this->datePayement,
				6 => &$this->dateEcheance,
				7 => &$this->ristourne,
				8 => &$this->remarque,
				9 => &$this->numFournisseur,
				10 => &$this->montantPaye 
		);
	}
	public function getLastInsert() {
		return $this->lastinsert;
	}
	/**
	 * add row achat
	 *
	 * @param RowAchat $rowAchat        	
	 */
	public function insert($rowAchat) {
		if ($this->insert == null) {
			throw new PDOException ( "Achat : driver_insert is null !", "-1", null );
		}
		
		try {
			$this->updateVars ( $rowAchat );
			$this->id = $this->lastinsert + 1;
			
			if ($this->insert->execute ()) {
				++ $this->lastinsert;
			}
		} catch ( PDOException $e ) {
			die ( "Erreur ! : " . $e->getMessage () );
			throw new PDOException ( "Achat => insert() : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
	}
	/**
	 * update row achat
	 *
	 * @param RowAchat $rowAchat        	
	 */
	public function update($rowAchat) {
		if ($this->update == null) {
			throw new PDOException ( "Achat : driver_update is null !", "-1", "" );
		}
		
		try {
			$this->updateVars ( $rowAchat );
			if ($this->update->execute ()) {
			}
		} catch ( PDOException $e ) {
			die ( "Erreur ! : " . $e->getMessage () );
			throw new PDOException ( "Achat => update() : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
	}
	/**
	 * Delete row achat number $id
	 *
	 * @param int $id        	
	 */
	public function delete($id) {
		if ($this->delete == null) {
			throw new PDOException ( "Achat : driver_delete is null !", "-1", "" );
		}
		$this->delete->execute ( array (
				':id' => $id 
		) );
		try {
			return $this->delete->execute ();
		} catch ( PDOException $e ) {
			die ( "Erreur ! : " . $e->getMessage () );
			throw new PDOException ( "Achat => delete() : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
	}
	/**
	 *
	 * @param RowAchat $rowAchat        	
	 */
	public function updateVars($rowAchat) {
		if ($rowAchat != null) {
			$this->id = ($rowAchat->data [RowAchat::$struct [0]]);
			$this->numFacFour = ($rowAchat->data [RowAchat::$struct [1]]);
			$this->dateFac = ($rowAchat->data [RowAchat::$struct [2]]);
			$this->numDocComp = ($rowAchat->data [RowAchat::$struct [3]]);
			$this->montant = ($rowAchat->data [RowAchat::$struct [4]]);
			$this->datePayement = ($rowAchat->data [RowAchat::$struct [5]]);
			$this->dateEcheance = ($rowAchat->data [RowAchat::$struct [6]]);
			$this->ristourne = ($rowAchat->data [RowAchat::$struct [7]]);
			$this->remarque = ($rowAchat->data [RowAchat::$struct [8]]);
			$this->numFournisseur = ($rowAchat->data [RowAchat::$struct [9]]);
			$this->montantPaye = ($rowAchat->data [RowAchat::$struct [10]]);
		}
	}
	/**
	 *
	 * @param RowAchat $rowAchat        	
	 */
	public function updateVars2($rowAchat) {
		if ($rowAchat != null) {
			for($i = 0; $i < RowAchat::$colums; ++ $i) {
				$this->vars [$i] = $rowAchat->data [RowAchat::$struct [$i]];
			}
		}
	}
	private function bindParams($pdoStatment) {
		if ($pdoStatment != null) {
			$pdoStatment->bindParam ( ':id', $this->id );
			$pdoStatment->bindParam ( ':numFacFour', $this->numFacFour );
			$pdoStatment->bindParam ( ':dateFac', $this->dateFac );
			$pdoStatment->bindParam ( ':numDocComp', $this->numDocComp );
			$pdoStatment->bindParam ( ':montant', $this->montant );
			$pdoStatment->bindParam ( ':datePayement', $this->datePayement );
			$pdoStatment->bindParam ( ':dateEcheance', $this->dateEcheance );
			$pdoStatment->bindParam ( ':ristourne', $this->ristourne );
			$pdoStatment->bindParam ( ':remarque', $this->remarque );
			$pdoStatment->bindParam ( ':numFournisseur', $this->numFournisseur );
			$pdoStatment->bindParam ( ':montantPaye', $this->montantPaye );
		}
		return $pdoStatment;
	}
	private function bindParams2($pdoStatment) {
		if ($pdoStatment != null) {
			for($i = 0; $i < RowAchat::$colums; ++ $i) {
				$this->vars [$i] = $rowAchat->data [RowAchat::$struct [$i]];
				$pdoStatment->bindParam ( $this->params [$i], $this->vars [$i] );
			}
		}
		return $pdoStatment;
	}
	private function getSqlInsert() {
		$structAchat = RowAchat::$paramsVars;
		;
		$vars = implode ( ',', array_keys ( $structAchat ) );
		
		$parms = implode ( ',', array_values ( $structAchat ) );
		$sql_insert = 'INSERT INTO' . ' ' . $this->name . ' (' . $vars . ')' . 'VALUES ' . '(' . $parms . ')';
		
		return $sql_insert;
	}
	private function getSqlUpdate() {
		$structAchat = RowAchat::$paramsVars;
		$vars = array_keys ( $structAchat );
		$parms = array_values ( $structAchat );
		$i = 0;
		$vars_parms = array ();
		$lenght = count ( $vars );
		$where_parm = $vars [$i] . "=" . $parms [$i];
		++ $i;
		
		while ( $i < $lenght ) {
			
			$vars_parms [$i] = $vars [$i] . "=" . $parms [$i];
			++ $i;
		}
		$vars_parms = implode ( ' , ', $vars_parms );
		$sql_update = "UPDATE " . $this->name . " SET " . $vars_parms . " WHERE " . $where_parm;
		
		return $sql_update;
	}
	private function getSqlDelete() {
		// penser de changer le nom de variable id si nï¿½cessaire
		return "DELETE FROM " . $this->name . " WHERE " . "id" . "=" . ':id';
	}
	private function getArrayVarParmPage($id_start, $id_end) {
		return array (
				':id_start' => $id_start,
				':id_end' => $id_end 
		);
	}
	private function getSqlSelectById() {
		
		// penser de changer le nom de variable id si nï¿½cessaire
		return "Select * FROM " . $this->name . " WHERE ID = :id";
	}
	private function getSqlSelectLastInsert() {
		return "SELECT max(ID) FROM  " . $this->name;
	}
	private function getSqlTotaleMontantPaye() {
		$colum = RowAchat::$totalMontantPaye;
		return "SELECT SUM($colum) FROM $this->name WHERE NumFournisseur=:numFour AND (year(DateEcheance)=:year  AND month(DateEcheance)=:month)";
	}
	public function getMontantPaye($where){
		$colum = RowAchat::$totalMontantPaye;
		$sql="SELECT SUM($colum) FROM $this->name $where";
		$statement=$this->driver->prepare($sql);
		$statement->execute();
		$row = $statement->fetch ();	
		return $row [0];
		
	}
	
	private function getSqlTotalePages() {
		return "SELECT * FROM $this->name WHERE NumFournisseur=:numFour AND (year(DateEcheance)=:year  AND month(DateEcheance)=:month)";
	}
	/**
	 * 
	 * @param int $numFour
	 * @param int $year
	 * @param int $month
	 * @param boolean $pages
	 * @return multitype:|mixed
	 */
	public function getMontantPayeOrPages($numFour, $year, $month, $pages) {
		if ($pages) {
			$this->select->execute ( array (
					':numFour' => $numFour,
					':year' => $year,
					':month' => $month
			) );
			$rows = $this->select->fetchAll(PDO::FETCH_NUM);
			return $rows;
		} else {
			$this->totalPaye->execute ( array (
					':numFour' => $numFour,
					':year' => $year,
					':month' => $month 
			) );
			$row = $this->totalPaye->fetch ();
			return $row [0];
		}
	}
	
	// public function get
}
class Fournisseurs {
	public $name = 'Fournisseurs';
	public $idFour = 'N°Fournisseur';
	public $nomFournisseur = 'NomFournisseur';
	/*
	public $contact = 'Contact';
	public $titreDuContact = 'TitreDuContact';
	public $adresse = 'Adresse';
	public $coePostal = 'CodePostal';
	public $ville = 'Ville';
	public $pays = 'Pays';
	public $numTel = 'Nï¿½Tï¿½l';
	public $gsm = 'Nï¿½Tï¿½lMobile';
	public $fax = 'Nï¿½Fax';
	public $email = 'NomEmail';
	public $conditionPay = 'ConditionsPaiement';
	public $remarque = 'Remarque';
	public $cptBanque = 'CPTBANQUE';
	public $tvaDed = 'TVADeductible';
	public $notVisibleProd = 'NotVisibleProd';
	*/
	static $primarykey = "N°Fournisseur";
	/**
	 *
	 * @var PDO
	 *
	 */
	private $driver;
	/**
	 *
	 * @var PDOStatement
	 */
	private $select = null;
	
	private $selectAll=null;
	
	/**
	 *
	 * @param PDO $driver        	
	 * @throws PDOException
	 */
	public function __construct($driver) {
		if ($driver == null) {
			throw new PDOException ( "Fournisseurs : driver is null !", "-1", "" );
		}
		$this->driver = $driver;
		
		try {
			$this->select = $this->driver->prepare ( "SELECT {$this->idFour}  FROM  {$this->name} WHERE {$this->nomFournisseur} = :nameFour" );
		    $this->selectAll=$this->driver->prepare($this->getSqlSelect ());
		} catch ( PDOException $e ) {
			die ( "Fournisseurs => __construct ! : " . $e->getMessage () );
			throw new PDOException ( "Fournisseurs => __construct : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
	}
	private function getSqlSelect() {
		return "SELECT {$this->idFour},{$this->nomFournisseur} FROM {$this->name}";
	}
	public function getIdByname($name) {
         
		if ($this->driver == null) {
			throw new PDOException ( "Fournisseurs: driver is null !", "-1", null );
		}
		try {
			
			$this->select->execute ( array (
					':nameFour' => $name
			) );
				
			$row = $this->select->fetch ();
			

			return ( int ) $row [0];
		} catch ( PDOException $e ) {
			die ( "Fournisseurs getIdByname ! : " . $e->getMessage () );
			throw new PDOException ( "Fournisseurs => getIdByname() : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
		
		/*
		 * $vars = $this->getNamesAndIds ( false ); return ( int ) $vars [$name];
		 */
	}
	
	
	/**
	 *
	 * @param boolean $idIsIndex        	
	 * @throws PDOException
	 * @return multitype:arry<String,String> |NULL
	 */
	public function getNamesAndIds($idIsIndex) {
		if ($this->driver == null) {
			throw new PDOException ( "Fournisseurs: driver_select is null !", "-1", null );
		}
		try {
			$this->selectAll->execute();
			$rows = $this->selectAll->fetchAll ( PDO::FETCH_NUM );
			$return = array ();
			if ($idIsIndex) {
				foreach ( $rows as $row ) {
					$return [$row [0] . ""] = $row [1];
				}
			} else {
				foreach ( $rows as $row ) {
					$return [$row [1] . ""] = $row [0];
				}
			}
		} catch ( PDOException $e ) {
			die ( "Fournisseurs _getNamesAndIds ! : " . $e->getMessage () );
			throw new PDOException ( "Fournisseurs => getNamesAndIds : \n" . $e->getMessage (), $e->getCode (), $e->getPrevious () );
		}
		return $return;
	}
}

?>
