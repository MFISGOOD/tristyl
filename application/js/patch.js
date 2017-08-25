var dialogAdd, dialogEdit, formAdd, formEdit, currentId;
var months = { 'Jr':1,'Fr':2,'Ms':3,'Al':4,'Mi':5,'Jn':6,'Jt':7,'At':8,'Se':9,'Oe':10,'Ne':11,'De':12 };
$(document)
		.ready(
				function() {

					var gg = $("#flex1").flexigrid({
						url : '../application/php/server.php',
						dataType : 'json',
						colModel : [ {
							display : 'Id',
							name : 'Achat.ID',
							width : 40,
							sortable : true,
							align : 'center'
						}, {
							display : 'NumFacFour',
							name : 'Achat.NumFacFour',
							width : 80,
							sortable : true,
							align : 'center'
						}, {
							display : 'DateFac',
							name : 'Achat.DateFac',
							width : 120,
							sortable : true,
							align : 'left'
						}, {
							display : 'NumDocComp',
							name : 'Achat.NumDocComp',
							width : 80,
							sortable : true,
							align : 'left'
						}, {
							display : 'Montant',
							name : 'Achat.Montant',
							width : 80,
							sortable : true,
							align : 'left'
						}, {
							display : 'DatePayement',
							name : 'Achat.DatePayement',
							width : 120,
							sortable : true,
							align : 'left',
							hide : false
						}, {
							display : 'DateEcheance',
							name : 'Achat.DateEcheance',
							width : 120,
							sortable : true,
							align : 'right'
						}, {
							display : 'Ristourne',
							name : 'Achat.Ristourne',
							width : 40,
							sortable : true,
							align : 'center'
						}, {
							display : 'Remarque',
							name : 'Achat.Remarque',
							width : 200,
							sortable : true,
							align : 'left'
						}, {
							display : 'Nom du fournisseur',
							name : 'Fournisseurs.NomFournisseur',
							width : 80,
							sortable : true,
							align : 'left'
						}, {
							display : 'MontantPaye',
							name : 'Achat.MontantPaye',
							width : 80,
							sortable : true,
							align : 'left'
						} ],
						buttons : [ {
							name : 'Ajouter',
							bclass : 'add',
							onpress : flexigrid_add
						}, {
							name : 'Editer',
							bclass : 'edit',
							onpress : flexigrid_edit
						}, {
							name : 'Supprimer',
							bclass : 'delete',
							onpress : flexigrid_delete
						}, {
							name : 'Afficher tous',
							bclass : 'search ',
							onpress : flexigrid_search
						}, {
							separator : true
						} ],
						searchitems : [ {
							display : 'ID',
							name : 'Achat.ID',
							isdefault : true
						}, {
							display : 'NumFacFour',
							name : 'Achat.NumFacFour',
						}, {
							display : 'MontantPaye',
							name : 'Achat.MontantPaye',
						} ],
						rpOptions : [ 50, 100, 200, 400, 800 ],

						sortname : "Achat.ID",
						sortorder : "desc",
						usepager : true,
						title : 'Achats',
						useRp : true,
						rp : 50,
						showTableToggleBtn : true,
						width : 'auto',
						height : 400
					});

					// add form search
					addformSearch();
					addRecord();
					$('.calcMontant').change(function(e) {
						calcMontantPaye();
					});
					$('.cal_Montant_edit').change(function(e) {
						calcMontantEdit();
					});
				
					// a revoir
					$('.mtpPlaceholder').change(
							function(e) {
								var Montant = $(
										"#formadd [name='Achat.Montant']")
										.attr('value');
								var Ristourne = $(
										"#formadd [name='Achat.Ristourne']")
										.attr('value');
								var MontantPaye = Montant
										- (Montant * Ristourne / 100);
								$("#formadd [name='Achat.MontantPaye']").attr(
										"title", MontantPaye.toFixed(2));

							});
					// end a revoir

					// load();
					$("#MySerach")
							.submit(
									function(event) {
										var _numFacFour=$('#mySearch_numFacFour').val();
										var _nameFour = $('#mySearch_name').val();
										var _year = $('#mySearch_year').val();
										var _month =months[$('#mySearch_month').val()[0] + $('#mySearch_month').val()[$('#mySearch_month').val().length - 1]];
										if(!_month ){
											_month="";
										}
										/*
										if (_nameFour == "" && _year == ""
												&& _month == "") {
											event.preventDefault();
											return;
										}
                                        */
										$('#flex1').flexOptions({
											newp : 1,
											params : [ {
												name : 'MYSEARCH',
												value : 'YES'
											},{
												name : 'numFacFour',
												value : _numFacFour
											}, 
											{
												name : 'name',
												value : _nameFour
											}, {
												name : 'year',
												value : _year
											}, {
												name : 'month',
												value : _month
											} ]
										});
										$('#flex1').flexReload();
										event.preventDefault();
										$
												.ajax({
													type : "GET",
													contentType : "application/x-www-form-urlencoded;charset=ISO-8859-1",
													url : "../application/php/all.php?nameFour="
															+ _nameFour
															+ "&year="
															+ _year
															+ "&month="
															+ _month
															+ "&numFacFour="
															+ _numFacFour,
													dataType : 'text',
													success : function(data) {
														$("#totalMontantPaye")
																.val(data);
													}
												});
									});// end form serach

					// create dialog add
					// --------------------------------------------------------
					function calcMontantPaye() {
						var text = "Montant payé";
						var Montant = $("#formadd [name='Achat.Montant']")
								.attr('value');
						var Ristourne = $("#formadd [name='Achat.Ristourne']")
								.attr('value');
						if (Montant && Ristourne) {
							var MontantPaye = Montant
									- (Montant * Ristourne / 100);
							$("#formadd [name='Achat.MontantPaye']").attr(
									"placeholder", MontantPaye.toFixed(2));

							$("#formadd label[for='MontantPaye']").text(
									text + MontantPaye.toFixed(2));

						} else {
							$("#formadd [name='Achat.MontantPaye']").attr(
									"placeholder", "$");

							$("#formadd label[for='MontantPaye']").text(text);
						}

					}
					
					function calcMontantEdit(){
						var Montant = $("#formedit [name='Achat.Montant']")
								.attr('value');
						var Ristourne = $("#formedit [name='Achat.Ristourne']")
								.attr('value');
						if (Montant && Ristourne) {
							var MontantPaye = Montant
									- (Montant * Ristourne / 100);
							$("#formedit [name='Achat.MontantPaye']").val(MontantPaye.toFixed(2));

						} else {
							
							$("#formedit [name='Achat.MontantPaye']").val('');
							$("#formedit[name='Achat.MontantPaye']").attr(
									"placeholder", "$");			
						}
					}
					function addRecord() {
						$nf("#form_add")
								.submit(
										function(event) {

											var ID = $(
													"#formadd [name='Achat.ID']")
													.attr('value');
											var NumFacFour = escape($(
													"#formadd [name='Achat.NumFacFour']")
													.attr('value'));
											var DateFac = $(
													"#formadd [name='Achat.DateFac']")
													.attr('value');
											var NumDocComp = $(
													"#formadd [name='Achat.NumDocComp']")
													.attr('value');
											var Montant = $(
													"#formadd [name='Achat.Montant']")
													.attr('value');
											var DatePayement = $(
													"#formadd [name='Achat.DatePayement']")
													.attr('value');
											var DateEcheance = $(
													"#formadd [name='Achat.DateEcheance']")
													.attr('value');
											var Ristourne = $(
													"#formadd [name='Achat.Ristourne']")
													.attr('value');
											var Remarque = $(
													"#formadd [name='Achat.Remarque']")
													.attr('value');
											var NumFournisseur =escape( $(
													"#formadd [name='Fournisseurs.NomFournisseur']")
													.attr('value'));
											var MontantPaye = $(
													"#formadd [name='Achat.MontantPaye']")
													.attr('value');
											if (!Remarque) {
												Remarque = ' ';
											}
											Remarque=escape(Remarque);
											var parms = "add=yes&" + "ID=" + ID
													+ "&NumFacFour="
													+ NumFacFour + "&DateFac="
													+ DateFac + "&NumDocComp="
													+ NumDocComp + "&Montant="
													+ Montant
													+ "&DatePayement="
													+ DatePayement
													+ "&DateEcheance="
													+ DateEcheance
													+ "&Ristourne=" + Ristourne
													+ "&Remarque=" + Remarque
													+ "&NumFournisseur="
													+ NumFournisseur
													+ "&MontantPaye="
													+ MontantPaye;
											
													
											$
													.ajax({
														type : "GET",
														dataType : "json",
														url : "../application/php/add.php?"
																+ parms,
														contentType : "application/x-www-form-urlencoded;charset=ISO-8859-1",
														success : function(data) {
															$nf(
																	'#form_add [type="reset"]')
																	.trigger(
																			"click");
															$(
																	"#formadd [name='Achat.MontantPaye']")
																	.attr(
																			"placeholder",
																			"$");

															$(
																	"#formadd label[for='MontantPaye']")
																	.text(
																			"Montant payé");

															$("#flex1")
																	.flexReload();

															$(
																	'#formadd input[name="Achat.ID"]')
																	.val(
																			data['lastId']);
															if (!confirm('Le record a été ajouté \n Voulez-vous continuer?')) {
																dialogAdd
																		.dialog("close");
															}

														},
														error : function(
																objAJAXRequest,
																strError) {
															$("#response")
																	.text(
																			"Error! Type: "
																					+ strError);
														}

													});
											event.preventDefault();

										});

					}// add
					dialogAdd = $nf("#formadd")
							.dialog(
									{
										autoOpen : false,
										height : 'auto',
										width : 'auto',
										modal : true,
										buttons : {
											"Reset" : function() {
												var save_id = $(
														'#formadd input[name="Achat.ID"]')
														.val();

												$nf('#form_add [type="reset"]')
														.trigger("click");
												$(
														"#formadd [name='Achat.MontantPaye']")
														.attr("placeholder",
																"$");
												$(
														"#formadd label[for='MontantPaye']")
														.text("Montant payé");
												$(
														'#formadd input[name="Achat.ID"]')
														.val(save_id);
											},
											"Ajouter" : function() {
												$nf('#form_add [type="submit"]')
														.trigger("click");
											},
											"Fermer" : function() {
												dialogAdd.dialog("close");
											}
										},
										close : function() {
											$nf("#form_add").trigger("reset");
											allFields
													.removeClass("ui-state-error");
										},
										open : function() {
											$
													.ajax({
														type : "GET",
														dataType : "json",
														url : "../application/php/add.php?lastId=yes",
														success : function(data) {

															$(
																	'#formadd input[name="Achat.ID"]')
																	.val(
																			data['lastId']);
														},
														error : function(
																objAJAXRequest,
																strError) {
															$("#response")
																	.text(
																			"Error! Type: "
																					+ strError);
														}

													});
										}
									});

					// end create dialog add
					// ----------------------------------------------------------------
					function updateRecord() {
						var ID = $("#formedit [name='Achat.ID']").attr('value');
						var NumFacFour =escape( $(
								"#formedit [name='Achat.NumFacFour']").attr(
								'value'));
						var DateFac = $("#formedit [name='Achat.DateFac']")
								.attr('value');
						var NumDocComp = $(
								"#formedit [name='Achat.NumDocComp']").attr(
								'value');
						var Montant = $("#formedit [name='Achat.Montant']")
								.attr('value');
						var DatePayement = $(
								"#formedit [name='Achat.DatePayement']").attr(
								'value');
						var DateEcheance = $(
								"#formedit [name='Achat.DateEcheance']").attr(
								'value');
						var Ristourne = $("#formedit [name='Achat.Ristourne']")
								.attr('value');
						var Remarque = $("#formedit [name='Achat.Remarque']")
								.attr('value');
						if (!Remarque) {
							Remarque = ' ';
						}
						Remarque=escape(Remarque);

						var NumFournisseur = escape($(
								"#formedit [name='Fournisseurs.NomFournisseur']")
								.attr('value'));
						var MontantPaye = $(
								"#formedit [name='Achat.MontantPaye']").attr(
								'value');

						var parms = "update=yes&" + "ID=" + ID + "&NumFacFour="
								+ NumFacFour + "&DateFac=" + DateFac
								+ "&NumDocComp=" + NumDocComp + "&Montant="
								+ Montant + "&DatePayement=" + DatePayement
								+ "&DateEcheance=" + DateEcheance
								+ "&Ristourne=" + Ristourne + "&Remarque="
								+ Remarque + "&NumFournisseur="
								+ NumFournisseur + "&MontantPaye="
								+ MontantPaye;
						$
								.ajax({
									type : "GET",
									dataType : "json",
									url : "../application/php/add.php?" + parms,
									contentType : "application/x-www-form-urlencoded;charset=ISO-8859-1",
									success : function(data) {
										$('#flex1').flexReload();
										if (!confirm('Le record a été modifié \n Voulez-vous continuer?')) {
											dialogEdit.dialog("close");
										}

									},
									error : function() {
										alert("update error");
									}

								});

					}
					function resetRow() {
						// display correct dialog content
						$
								.ajax({
									type : "GET",
									dataType : "json",
									url : "../application/php/edit.php?idEdit="
											+ currentId,
									success : function(data) {

										var json_obj = data;// parse JSON
										if (json_obj['Achat.ID'] == '') {
											alert('Edit error....!');
										} else {
											$(
													'#formedit input[name="Achat.ID"]')
													.val(json_obj['Achat.ID']);
											$(
													'#formedit input[name="Achat.NumFacFour"]')
													.val(
															json_obj['Achat.NumFacFour']);
											$(
													'#formedit input[name="Achat.DateFac"]')
													.val(
															json_obj['Achat.DateFac']);
											$(
													'#formedit input[name="Achat.NumDocComp"]')
													.val(
															json_obj['Achat.NumDocComp']);
											$(
													'#formedit input[name="Achat.Montant"]')
													.val(
															json_obj['Achat.Montant']);
											$(
													'#formedit input[name="Achat.DateEcheance"]')
													.val(
															json_obj['Achat.DateEcheance']);
											$(
													'#formedit input[name="Achat.Ristourne"]')
													.val(
															json_obj['Achat.Ristourne']);
											$(
													'#formedit input[name="Achat.MontantPaye"]')
													.val(
															json_obj['Achat.MontantPaye']);
											$(
													'#formedit input[name="Achat.DatePayement"]')
													.val(
															json_obj['Achat.DatePayement']);
											$(
													'#formedit [name="Achat.Remarque"]')
													.val(
															json_obj['Achat.Remarque']);
											$(
													'#formedit input[name="Fournisseurs.NomFournisseur"]')
													.val(
															json_obj['Fournisseurs.NomFournisseur']);
										}
									},
									error : function(wrong) {
										alert("Error : " + wrong);
									}
								});
					}
					function supprimerRow() {
						var ID = $("#formedit [name='Achat.ID']").attr('value');
						if (confirm('Confirmer pour supprimer le record n°: '
								+ ID)) {
							var itemlist = ID + '';
							$.ajax({
								type : "POST",
								dataType : "json",
								url : "../application/php/server.php",
								data : "items=" + itemlist,
								success : function(data) {
									$("#flex1").flexReload();
									dialogEdit.dialog("close");
								},
								error : function() {
									alert("Error not connected");
								}
							});
						}
					}
					function editRow(com, grid) {
						// display correct dialog content
						currentId = getid();
						$
								.ajax({
									type : "GET",
									dataType : "json",
									url : "../application/php/edit.php?idEdit="
											+ currentId,
									success : function(data) {

										var json_obj = data;// parse JSON
										if (json_obj['Achat.ID'] == '') {
											alert('Edit error....!');
										} else {
											$(
													'#formedit input[name="Achat.ID"]')
													.val(json_obj['Achat.ID']);
											$(
													'#formedit input[name="Achat.NumFacFour"]')
													.val(
															json_obj['Achat.NumFacFour']);
											$(
													'#formedit input[name="Achat.DateFac"]')
													.val(
															json_obj['Achat.DateFac']);
											$(
													'#formedit input[name="Achat.NumDocComp"]')
													.val(
															json_obj['Achat.NumDocComp']);
											$(
													'#formedit input[name="Achat.Montant"]')
													.val(
															json_obj['Achat.Montant']);
											$(
													'#formedit input[name="Achat.DateEcheance"]')
													.val(
															json_obj['Achat.DateEcheance']);
											$(
													'#formedit input[name="Achat.Ristourne"]')
													.val(
															json_obj['Achat.Ristourne']);
											$(
													'#formedit input[name="Achat.MontantPaye"]')
													.val(
															json_obj['Achat.MontantPaye']);
											$(
													'#formedit input[name="Achat.DatePayement"]')
													.val(
															json_obj['Achat.DatePayement']);
											$(
													'#formedit [name="Achat.Remarque"]')
													.val(
															json_obj['Achat.Remarque']);
											$(
													'#formedit input[name="Fournisseurs.NomFournisseur"]')
													.val(
															json_obj['Fournisseurs.NomFournisseur']);
										}
									},
									error : function(wrong) {
										alert("Error : " + wrong);
									}
								});
					}
					dialogEdit = $nf("#formedit").dialog({
						autoOpen : false,
						height : 'auto',
						width : 'auto',
						modal : true,
						buttons : {
							"Reset" : resetRow,
							"Supprimer" : supprimerRow,
							"Modifier" : updateRecord,
							"Fermer" : function() {
								dialogEdit.dialog("close");
							}
						},
						open : editRow,
						close : function() {
						}

					});

					// end create dialog add

					// datepickes
					$nf('#form_add input[type="date"]').datepicker({
						dateFormat : "yy-mm-dd",
						changeMonth : true,
						changeYear : true
					});
					$nf('#form_edit input[type="date"]').datepicker({
						dateFormat : "yy-mm-dd",
						changeMonth : true,
						changeYear : true
					});
					$nf('#ui-datepicker-div').css('clip', 'auto');

					// end datepickers

				});
function getid(com, grid) {
	var id = '';
	$('.trSelected', grid).each(function() {
		id = $(this).attr('id');
		id = id.substring(id.lastIndexOf('row') + 3);
	});
	return id;
}
function flexigrid_add(com, grid) {
	dialogAdd.dialog("open");
}
function flexigrid_delete(com, grid) {
	var msg = '';
	if ($('.trSelected', grid).length > 0) {
		if ($('.trSelected', grid).length == 1) {
			msg = 'Confirmer pour supprimer le record n°: ' + getid(com, grid)
					+ ' ?';
		} else {
			msg = 'Confirmer pour supprimer les '
					+ $('.trSelected', grid).length + ' records?';

		}
		if (confirm(msg)) {
			var items = $('.trSelected', grid);
			var itemlist = '';
			for (i = 0; i < items.length; i++) {
				itemlist += items[i].id.substr(3) + ",";
			}
			$.ajax({
				type : "POST",
				dataType : "json",
				url : "../application/php/server.php",
				data : "items=" + itemlist,
				success : function(data) {
					$("#flex1").flexReload();
				},
				error : function() {
					alert("Error not connected");
				}
			});
		}
	} else {
		confirm('Select rows for delete it');
		return false;
	}

}
function flexigrid_delete2(com, grid) {
	if ($('.trSelected', grid).length > 0) {
		if (confirm('Delete ' + $('.trSelected', grid).length + ' items?')) {
			var items = $('.trSelected', grid);
			var itemlist = '';
			for (i = 0; i < items.length; i++) {
				itemlist += items[i].id.substr(3) + ",";
			}
			$.ajax({
				type : "POST",
				dataType : "json",
				url : "../application/php/server.php",
				data : "items=" + itemlist,
				success : function(data) {
					$("#flex1").flexReload();
				},
				error : function() {
					alert("Error not connected");
				}
			});
		}
	} else {
		confirm('Select rows for delete it');
		return false;
	}

}
function flexigrid_edit(com, grid) {
	if ($('.trSelected', grid).length > 0) {

		dialogEdit.dialog("open");
	} else {
		return false;
	}

}
function flexigrid_search(com, grid) {
	$('#MySerach input[type="reset"]').trigger("click");
	$("#totalMontantPaye").val("");

	$('#flex1').flexOptions({
		newp : 1,
		params : [ {
			name : 'MYSEARCH',
			value : 'NO'
		} ]
	});

	$('#flex1').flexReload();

}
/*
 * function load() { // Setup the ajax indicator $('body').append( '<div
 * id="ajaxBusy"><p><img src="images/load.gif"></p></div>');
 * 
 * $('#ajaxBusy').css({ display : "none", margin : "0px", paddingLeft : "0px",
 * paddingRight : "0px", paddingTop : "0px", paddingBottom : "0px", position :
 * "absolute", right : "3px", top : "3px", width : "auto" }); } // Ajax activity
 * indicator bound to ajax start/stop document events
 * $(document).ajaxStart(function() { $('#ajaxBusy').show();
 * }).ajaxStop(function() { $('#ajaxBusy').hide(); });
 */
