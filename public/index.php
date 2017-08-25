<?php
require_once ('../application/mdb/MDB.php');
$achat = new MDB ();
$list = array_keys ( $achat->fournisseurs->getNamesAndIds ( false ) );
// fourn's name
$default = null;
$json = null;
$idEdit = $achat->achat->getLastInsert ();
if ($idEdit != null)
	++ $idEdit;
$virtuelRow = null;
if (isset ( $_GET ['idEdit'] )) {
	$virtuelRow = $achat->getDataById ( $_GET ['idEdit'] ); // $_POST ['IdEdit']);
	$json = $virtuelRow->data;
	$idEdit = $_GET ['idEdit'];
}

// $saerch = '<div id="tristyl_Search" title="">';
date_default_timezone_set ( 'Europe/paris' );
$year = date ( "Y" );
$yearmin = $year - 20;
$yearmax = $year + 20;
// numFacFour
$numFacFour = '<span  id="span_numFacFour">';
$numFacFour .= '<input id="mySearch_numFacFour" placeholder="NumFacFour" type="text"/>';
// end numFacFour
// name
$name = '<span  id="span_nameFour">';
$name .= '<input id="mySearch_name" placeholder="Nom du fournisseur" list="list_names"/>';
$name .= '<datalist id="list_names">';

foreach ( $list as $value ) {
	$var = addslashes ( htmlentities ( $value ) );
	$name .= "<option value=\"$var\"/>";
}
$name .= '</datalist></span>';

// end name
// year
$year = '<span  "id="span_year">';
$year .= '<input type="text" id="mySearch_year" list="list_years" placeholder="Année" />';
$year .= '<datalist id="list_years">';

for($i = $yearmin; $i < $yearmax; ++ $i) {
	$year .= "<option value=\"$i\"/>";
}
$year .= '</datalist></span>';
// end year
// month
$month = '<span  id="span_month">';
$month .= '<input type="text" id="mySearch_month" list="list_months" placeholder="Mois"/>';
$month .= '<datalist id="list_months">';
$mois = array (
		'Janvier',
		'Février',
		'Mars',
		'April',
		'Mai',
		'Juin',
		'Juillet',
		'Août',
		'Septembre',
		'Octobre',
		'Novembre',
		'Décembre' 
);
for($i = 0; $i < 12; ++ $i) {
	$month .= "<option value=\"$mois[$i]\"/>";
}
$month .= '</datalist></span>';
// end month

// $saerch .='</div>';
$total = '<div class="myTotal">   Total:<input type="text" id="totalMontantPaye" name="total" value="" ></div>';
header('Content-Type: text/html; charset=ISO-8859-1');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>tristyl</title>
<link rel="stylesheet" type="text/css"
	href="../application/css/flexigrid.css" />
<link rel="stylesheet" type="text/css" href="../application/css/my.css" />
<link rel="stylesheet" type="text/css" href="../application/css/add.css" />



<script type="text/javascript" src="../application/js/jquery.min.js"></script>
<script type="text/javascript" src="../application/js/jquery-ui.min.js"></script>
<script type="text/javascript">
	var $nf = jQuery.noConflict();
</script>
<link type="text/css" href="../application/css/base/ui.all.css"
	rel="stylesheet" />
<link rel="stylesheet" href="../application/css/jquery-ui.css">


<script type="text/javascript"
	src="../application/js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript"
	src="../application/js/ui/ui.datepicker.js"></script>
<script type="text/javascript"
	src="../application/js/ui/i18n/ui.datepicker-id.js"></script>
<script type="text/javascript" src="../application/js/flexigrid.js"></script>

<script type="text/javascript" src="../application/js/patch.js"></script>
<style>
article, aside, figure, footer, header, hgroup, menu, nav, section {
	display: block;
}
</style>

</head>

<body>
	<!--  
	<form id="fmFilter">
		<input id="fmFilterSel1" name="fmFilterSel1" type="input" /> <input
			id="fmFilterSel2" name="fmFilterSel2" type="checkbox" /> <input
			id="fmFilterSel3" name="fmFilterSel3" type="text" />
	</form>
	-->
	<table id="flex1" style="display: none"></table>
	<br />
	<br />

	<div class="add_edit" id="formadd" style="display: none" title="">
		<form autocomplete="on" method="post" id="form_add" name="form_add"
			action="">
			<!-- action="add.php" -->
			<fieldset>
				<ol>
					<li><label for="ID">Record N°</label><input required type="text"
						id="Achat.ID" name="Achat.ID" readonly /></li>
					<li><label for="NumFacFour">Numéro de document du fournisseur</label><input
						autofocus required type="text" id="Achat.NumFacFour"
						name="Achat.NumFacFour"></li>
					<li><label for="DateFac">Date de la facture</label><input required
						type="date" id="Achat.DateFac" name="Achat.DateFac" /></li>
					<li><label for="NumDocComp">Numéro du document comptable</label><input
						required step="1" type="number" id="Achat.NumDocComp"
						name="Achat.NumDocComp" value="0" /></li>
					<li><label for="Montant">Montant de la facture</label><input
						placeholder="$" required step="0.01" type="number"
						id="Achat.Montant" name="Achat.Montant" class="calcMontant" /></li>
				</ol>
			</fieldset>
			<fieldset>
				<ol>
					<li><label for="DateEcheance">Date d'échéance</label><input
						required type="date" id="Achat.DateEcheance"
						name="Achat.DateEcheance" /></li>
					<li><label for="Ristourne">Ristourne accordée</label><input
						required step="0.01" type="number" id="Achat.Ristourne"
						name="Achat.Ristourne" value="4.0" class="calcMontant" /></li>

					<li><label for="NumFournisseur">Nom fournisseur</label><input
						type="text" required id="Fournisseurs.NomFournisseur"
						name="Fournisseurs.NomFournisseur" list="listNames"> <datalist
							id="listNames">
							<option value=''></option>
							
                        <?php
																								
							foreach ( $list as $value ) {
								$var = htmlentities ( $value );
								echo "<option value=\"$var\">$var</option>";
							}
						?>
																								
							</datalist></li>

					<li><label for="MontantPaye">Montant payé</label><input
						placeholder="$" required step="0.01" type="number"
						id="Achat.MontantPaye" name="Achat.MontantPaye"
						class="mtpPlaceholder" /></li>
					<li><label for="DatePayement">Date Payement</label><input required
						type="date" id="Achat.DatePayement" name="Achat.DatePayement" /></li>



				</ol>

				<div style="display: none">
					<input type="reset" value="Reset" id="reset" /><input type="submit"
						value="Send" id="submit" />
				</div>

			</fieldset>
			<!-- Allow form submission with keyboard without duplicating the dialog button -->
			<div class="remarque_add">
				<label for="Remarque">Remarque</label>
				<textarea id="Achat.Remarque" name="Achat.Remarque"
					class="textAreaRemarque"></textarea>
			</div>

		</form>
	</div>
	<div class="add_edit" id="formedit" style="display: none" title="">
		<form autocomplete="on" method="post" id="form_edit" name="form_edit"
			action="">
			<!-- action="add.php" -->
			<fieldset>
				<ol>
					<li><label for="ID">Record N°</label><input required type="text"
						id="Achat.ID_edit" name="Achat.ID" readonly /></li>
					<li><label for="NumFacFour">Numéro de document du fournisseur</label><input
						autofocus required type="text" id="Achat.NumFacFour_edit"
						name="Achat.NumFacFour"></li>
					<li><label for="DateFac">Date de la facture</label><input required
						type="date" id="Achat.DateFac_edit" name="Achat.DateFac" /></li>
					<li><label for="NumDocComp">Numéro du document comptable</label><input
						required step="1" type="number" id="Achat.NumDocComp_edit"
						name="Achat.NumDocComp" /></li>
					<li><label for="Montant">Montant de la facture</label><input
						placeholder="$" required step="0.01" type="number"
						id="Achat.Montant_edit" name="Achat.Montant"
						class="cal_Montant_edit" /></li>
				</ol>
			</fieldset>
			<fieldset>
				<ol>
					<li><label for="DateEcheance">Date d'échéance</label><input
						required type="date" id="Achat.DateEcheance_edit"
						name="Achat.DateEcheance" /></li>
					<li><label for="Ristourne">Ristourne accordée</label><input
						required step="0.01" type="number" id="Achat.Ristourne_edit"
						name="Achat.Ristourne" class="cal_Montant_edit" /></li>

					<li><label for="NumFournisseur">Nom fournisseur</label><input
						type="text" required id="Fournisseurs.NomFournisseur_edit"
						name="Fournisseurs.NomFournisseur" list="listNames"> <datalist
							id="listNames">
							<option value=''></option>
							
                         <?php
																								
							foreach ( $list as $value ) {
								$var = htmlentities ( $value );
								echo "<option value=\"$var\">$var</option>";
							}
					     ?>
																								
							</datalist></li>

					<li><label for="MontantPaye">Montant payé </label><input
						placeholder="$" required step="0.01" type="number"
						id="Achat.MontantPaye_edit" name="Achat.MontantPaye" /></li>
					<li><label for="DatePayement">Date Payement</label><input required
						type="date" id="Achat.DatePayement_edit" name="Achat.DatePayement" /></li>
				</ol>
			</fieldset>
			<div class="remarque_edit">
				<label for="Remarque">Remarque</label>
				<textarea id="Achat.Remarque_edit" name="Achat.Remarque"
					class="textAreaRemarque"></textarea>
			</div>
			<!-- Allow form submission with keyboard without duplicating the dialog button -->

		</form>
	</div>
<script type="text/javascript">
<?php
	echo 'function addformSearch(){';
	echo "var divSearchName ='$name';"; // parse JSON
	echo "var divSearchYear ='$year';"; // parse JSON
	echo "var divSearchMonth ='$month';"; // parse JSON
	echo "var divSearchNumFacFour ='$numFacFour';"; // parse JSON
	
	$search = "<div class=\"tristyl_search\" ><form id=\"MySerach\" action=\"\">$numFacFour $name $year $month <input type=\"submit\" value=\"\" id=\"myButtonSearch\" ><div style=\"display: none\"><input type=\"reset\" value=\"Reset\" id=\"reset2\" /></div></form></div>";
	echo "var search ='$search';"; // parse JSON
	
	echo "var total ='$total';"; // parse JSON
	echo "\$nf('.flexigrid div .tDiv2').after(search);";
	// echo "\$nf('.flexigrid div .tristyl_search').after(total);";
	
	/*
	 * echo "\$nf('.flexigrid div .tDiv2').append(divSearchName);"; echo "\$nf('.flexigrid div .tDiv2').append(divSearchYear);"; echo "\$nf('.flexigrid div .tDiv2').append(divSearchMonth);";
	 */
	echo "\$nf('.flexigrid div .pDiv2').after(total);";
	echo '}';
?>																				
</script>
</body>
</html>