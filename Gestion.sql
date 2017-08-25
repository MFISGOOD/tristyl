# File name: C:/Users/Ryan/Desktop/Gestion.sql
# Creation date: 08/25/2017
# Created by Access to MySQL 6.5 [Demo]
# --------------------------------------------------
# More conversion tools at http://www.convert-in.com

SET NAMES utf8;

#
# Table structure for table 'Fournisseurs'
#

DROP TABLE IF EXISTS `Fournisseurs` CASCADE;
CREATE TABLE `Fournisseurs` (
  `N°Fournisseur` DOUBLE NOT NULL DEFAULT 0.0000000000000000e+000,
  `NomFournisseur` VARCHAR(50) CHARACTER SET utf8,
  `Contact` VARCHAR(50) CHARACTER SET utf8,
  `TitreDuContact` VARCHAR(50) CHARACTER SET utf8,
  `Adresse` VARCHAR(255) CHARACTER SET utf8,
  `CodePostal` VARCHAR(20) CHARACTER SET utf8,
  `Ville` VARCHAR(50) CHARACTER SET utf8,
  `Pays` VARCHAR(50) CHARACTER SET utf8,
  `N°Tél` VARCHAR(30) CHARACTER SET utf8,
  `N°TélMobile` VARCHAR(30) CHARACTER SET utf8,
  `N°Fax` VARCHAR(30) CHARACTER SET utf8,
  `NomEmail` VARCHAR(50) CHARACTER SET utf8,
  `ConditionsPaiement` VARCHAR(255) CHARACTER SET utf8,
  `Remarque` LONGTEXT CHARACTER SET utf8,
  `CPTBANQUE` VARCHAR(255) CHARACTER SET utf8,
  `TVADeductible` DOUBLE,
  `NotVisibleProd` BIT,
  INDEX `CodePostal` (`CodePostal`),
  INDEX `Contact` (`Contact`),
  INDEX `NomEmail` (`NomEmail`),
  INDEX `NomFournisseur` (`NomFournisseur`),
  PRIMARY KEY (`N°Fournisseur`)
) ENGINE=MyISAM;

#
# Dumping data for table 'Fournisseurs'
#

LOCK TABLES `Fournisseurs` WRITE;
INSERT IGNORE INTO `Fournisseurs`(`N°Fournisseur`, `NomFournisseur`, `Contact`, `TitreDuContact`, `Adresse`, `CodePostal`, `Ville`, `Pays`, `N°Tél`, `N°TélMobile`, `N°Fax`, `NomEmail`, `ConditionsPaiement`, `Remarque`, `CPTBANQUE`, `TVADeductible`, `NotVisibleProd`) VALUES(1.0000000000000000e+000, 'ROY ROBSON FASHION', 'MR. BISCHOF ', 'DIRECTEUR', 'POSTFACH 1920  D-21309 LÜNEBURG', 'D-21337', 'LÜNEBURG', 'GERMANY', '00 49 4131 887 157', ' ', '(04131)887200', 'WWW.ROYROBSON.COM', '10J/4% -    30J/2,25% -    60J/NET', 'Jeroen Jansen - Brandz Modeagenturen
email: jeroen@brandz-modeagenturen.com
gsm: +31 6 31691657
Showroom, Adriaan Brouwersstraat, 31, 1 verdieping, 2000 Antwerpen
tel 03 233 42 00 fax 03 475 92 00


REPR-MR. ONGENAET 092/27.04.24 OU 0475/41.19.57 

Eeklostraat 47
9030 Mariakerke
Gent
Belgie', '290-0037478-57', 0.0000000000000000e+000, 0), (2.0000000000000000e+000, 'ETERNA', 'FOX N.V.', 'REPR. MR. VOSSEN', ' ', ' ', ' ', ' ', ' ', ' ', ' ', 'vossenfox@skynet.be', '10J / 4% -    30J / 2,25% -   60J/NET ', 'Agent Philippe Vander Eijcken +32 475 582 268 philippe.vandereycken@hotmail.com
coordonnées bancaires
IBAN
DE84740400820620335000
BIC
COBA DE FF
showroom:
Fox n.v./s.a.
Hoevedreef z/n
3630 Maasmechelen
Belgie
tel +32 89 722 860

BIC-COBA DE FF                                                                                                                                                                                                                                                                  IBAN-DE 27700800000776777800  -  BIC - DRES DE FF', ' ', 0.0000000000000000e+000, 0), (3.0000000000000000e+000, 'VAN WINKEL (LEDUB)', 'MR.HENDRIKS', ' ', 'BAALHOEK 48', '1853 ', 'STROMBEEK - BEVER ', 'BELGIQUE ', '02/267.18.42 ', ' ', '02/267.71.04 ', ' ', '10J /4.50%     - 30J / 2% -      60J / NET ', 'OU CCP 000-0454819-83

Adresse de retour pour 12 chemise maximum
Van Winkel Fashions
Antwoordnummer 3
3930 Hamont-Achel

Pour un retour de plus de 12 chemises contactez directement Van Winkel pour organiser un retour avec leur transporteur
Belgique', '438-7183501-86', NULL, 0), (4.0000000000000000e+000, 'SORANO', 'MR. CROSSMANN', 'REP. MR. G. MEYLEMANS    0495/51.30.72', 'CALWER STRASSE 81', '72202 ', 'NAGOLD ', 'GERMANY ', '00 49 74 52.60.41.32', ' ', '00 49 74 52.60.41.69', 'INFO@SORANOSUITS.DE', '10J/4% -    30J / 2.25% -    60J / NET', ' ', '210-0916010-91', NULL, 0), (5.0000000000000000e+000, 'BUGATTI (CUIR) -HEINZ KAPRAUN', 'DYCO', 'MR VANDENBOS ', 'Boechoutlaan 107', '1853', 'STROMBEEK - BEVER ', 'BELGIQUE', ' ', ' ', ' ', ' ', '10J / 4% -   30J / NET ', ' ', ' 179-6319511-82', 0.0000000000000000e+000, 0), (6.0000000000000000e+000, 'DIGEL', 'MR. Hubert Bilger  /  49./0/ 175 43 55 937', 'REP. MR. G. MEYLEMANS 0495/51.30.72', 'Carl-Friedrich-Gauss-Strasse 5', '72202 ', 'NAGOLD ', 'GERMANY ', '00 49 74 52.60.41.32', ' ', '00 49 74 52.60.41.69', 'INFO@SORANOSUITS.DE', '10J/4% -   30J / 2.25% -    60J / NET', 'agent pour la Belgique chez Digel
Elisabeth Schanz e.schanz@digel.de
+49-7452-604-238
export manager : Cristobal Felipe Machhaus c.machhaus@digel.de
+49 (0) 7452 60 42 88 fax +49 (0) 7452 60 41 84 

h.bilger@digel.de
Meylemans Geert
Nieuwstraat 30 2222 Hegem ( privé ) 

Jozef Van Elewijckstraat 86 ( showroom ) 
1853 Strombeek Bever', '210-0916010-91', 0.0000000000000000e+000, 0), (7.0000000000000000e+000, 'LEYVA', 'REPR. MR. ARIEL ZIMMERMAN', '0475/915.519', ' ', '23700', 'LINARES', 'ESPAGNE', '0034 953 690 922 ', ' ', '0034 953 651 948', 'A@LEYVA.COM', ' ', 'CPTE BANQUE IBAN ES25 0049 0041 4720 1010 7951 BIC(SWIFT) BSCHES MM', ' ', NULL, 0), (8.0000000000000000e+000, 'D.V.F. S.R.L    ', 'MR. PAOLO DE LAVIGNE   -  ELENA  -', 'DIRECTEUR', 'Via A. Lenticchia 16 -20', '22100', 'COMO ', 'ITALIE ', '0039/031.59.08.98 ', ' ', '0039/031.59.14.67', 'DVF@SYSTEMSLINE.IT', '10J / 3%', 'BIC: IBSP ITTM 241

 ', 'IT65 A01025 10900 1000 0000 7584', NULL, 0), (9.0000000000000000e+000, 'DORE DORE', 'R.V.B. TEXTILES', 'MR. ROLAND et YVES VAN BUGGENHOUT', 'BERGDAL 18 BTE 1', '1853 ', 'STROMBEEK - BEVER ', 'BELGIQUE ', '02/267.41.75 ', '0475/20.31.89', '02/267.44.08 ', 'order.rvbtextiles@skynet.be', '10J/3%  -     60J ET LE MOIS /NET', '10J/3% - OU 60J ET LE MOIS/NET', '310/1773628/69', NULL, 0), (1.0000000000000000e+001, 'Bugatti GmbH (F.W. Brinkmann GmbH)', 'DYCO ', 'MR.VANDEBOS', 'Boechoutlaan 107', '1853', 'STROMBEEK - BEVER', 'BELGIQUE ', ' ', ' ', ' ', ' ', '10J / 4% -   30J / 2% -    60J / NET', 'Bugatti GmbH
Hansastrasse 55
D-32049 Herford
Tel +49 (0) 5221 / 884-0
Fax +49 (0) 5221 / 884-281
info@bugatti.de
www.bugatti-fashion.com
UST-ID-Nr. DE 811 156 103', ' 179-6319511-82', 0.0000000000000000e+000, 0), (1.1000000000000000e+001, 'MOBIL ELASTO', 'FOX N.V.', 'REPR. MR. P. VOSSEN ', 'CHAUSSÉE DES GRENADIERS 86', '4690', 'EBEN - EMAEL ', ' ', '04/286.44.85 ', ' ', '04/286.55.09 ', 'VOSSENFOX@BUSMAIL.NET', '10J / 4% -    30J / 2,25% -   60J/NET ', ' ', '688-1019945-92', NULL, 0), (1.2000000000000000e+001, 'BARKER SHOES LTD', 'REPRÉSENTANT : MR. DE BOCK', ' ', 'STATION ROAD, EARLS BARTON', 'NN6 0NT', 'NORTHAMPTON ', 'ANGLETERRE', '01604 810387', ' ', '01604 812350', 'BARKER@BARKERSHOES.CO.UK', ' ', 'Philippe Schuermans
Linko Diffusion
Fr. De Merodestraat 86, 2800 Mechelen
Belgium
+32 477 747 999
p.schuermans@skynet.be

SWIFT : N W B K G B 2 L    
IBAN : GB 16  NWBK  60 72 06 40 19 28 65
', 'IBAN-GB16-NWBK-6072 0640 1928 65', NULL, 0), (1.3000000000000000e+001, 'FALABELLA - DESIN FOR MEN AND WOMAN  B.V. ', ' ', ' ', 'Tokyostraat  1-5', '1175', 'RB Lijnden', 'PAYS-BAS', '00-31-20 659 66 95', ' ', '00-31-20 659 66 85', 'INFO@LACERNA-RAGAZZO.COM', '10J/ 3,% - 60J / NET', 'BIC: ABNANL 2A                                                                                                                                                                                                                                                          REPRESENTAN  :   MR .  JAN  VAN  CAESBAOECK    . TEL  .03. 353 .87 .40 -         GSM  0475.902811                                                                                                                                                                                                                                                              IBAN : NL 47 ABNA  0432105905 - BIC : ABNANL.2.A                                                        ABN   AMRO . BANK  -  ROTTERDAM', 'IBAN: NR47 ABNA 0432 1059 05', NULL, 0), (1.4000000000000000e+001, 'GRAVATI', 'MR. GRAVATI', 'DIRECTEUR COMMERCIAL', 'VIA DEGLI ORTI 36', '27029', 'VIGEVANO', 'ITALY', '0039 0381 691.329', ' ', '0039 0381 881.106', ' ', '10J / 4% - 60J /NET', ' CASELLA POSTALE N. 61', 'CCP-15096274', NULL, 0), (1.5000000000000000e+001, 'S.A.MINIOX', 'PINTURAS  Y  DECORACION', ' ', 'CHE DE WATERLOO  N°643', '1050', 'BRUXELLES', ' ', '02.343.33.33.', ' ', '02.347.06.83', ' ', ' ', ' ', '000/0701418/11', NULL, 0), (1.6000000000000000e+001, 'MOESE & SCHWARTZ - HEMLEY', 'MR ARIEL ZIMMERMAN', 'REPRÉSENTANT', 'HÜLSER STRASSE 335', '47803', 'KREFELD', 'GERMANY', '0 2151 87 59 45', ' ', ' 0 2151 87 59 47', ' ', '10J/4% - 30J/2.25 - 60J/NET', ' ', 'POSTFACH 10 15 03', NULL, 0), (1.7000000000000000e+001, 'INITIAL TEXTILES -  CARPET SA', 'Mr. Vincent Trompet ', ' Manager', 'Rue Dr. Elie Lambotte, 177', '1030', 'Bruxelles', 'BELGIQUE', '02/240.82.70', ' ', ' 02/245.59.07', ' ', 'FACTURE PAYABLE COMPTANT', ' ', '413-4513901-63', NULL, 0), (1.8000000000000000e+001, 'CLOITRE I SA', ' Mr. David  De Winter  -  traveau -', ' TEL. 02 743 24 23', 'AV. DE ROODEBEECK 89', '1030', 'BRUXELLES', 'BELGIQUE', '02 743 24 23', ' ', ' ', ' d.dewinter@omnium.be', ' ', 'SECRÉTAIRE :  DENISE GEERENS
responsable décompte des charges M. Debliquy 02/743 24 31 comptabilite@palladiumgroup.be', '435-0328761-11', 0.0000000000000000e+000, 0), (1.9000000000000000e+001, 'FOREZ EMBALLAGES S.A.', 'ANDREU TEXIDO / représentant mr Bulle Xavier', ' Tel : 00 34 938439004', ' ', ' ', ' ', ' ', '(33)04 77 52 57 74', 'belgique0498/546.401', ' ', 'Mari-l Boyé  -  france@texido.com', ' ', 'BIC   : CEPAFRPP 426
bulle_xavier@hotmail.com
belgique0498/546.401

', 'IBAN: FR7614265006000877620564 514', NULL, 0), (2.0000000000000000e+001, 'GALERIES ROYALES ST-HUBERT', 'DANNY -MICHEL BEUN', 'ETALAGISTE', 'GALERIE DU ROI 5', '1000', 'BRUXELLES', 'BELGIQUE', '02/502.45.89', ' ', '02/502.45.89', ' ', 'NET', ' ', '430-0390851-29', NULL, 0), (2.1000000000000000e+001, 'CKD sprl', 'RAPHAEL CHEVALIER', 'PRODUCT MANAGER', 'KALKOVEN 50', '1730', 'ASSE', 'BELGIUM', '02/453.98.73', '0475/250.725', '02/453.09.30', ' chevalier@microconcept.org', ' ', ' ', '210-0150344-46', 0.0000000000000000e+000, 0), (2.2000000000000000e+001, 'PARTENA', 'Cheverier Joanne', 'GESTIONNAIRE', 'RUE DES CHARTREUX 57', '1000', 'BRUXELLES', 'BELGIQUE', '02/549.33.88', ' ', '02/512.90.79', ' bru25.sect2@partena.be', 'a.andre@partena.be', 'Cheverier Joanne 02/549.33.88 fax 02/512.90.79 bru28.sect1@partena.be
Service juridique 02/549.30.10
Team manager Boujtat Chomicha 02/549.37.22 fax 02/512.56.43 cboujtat@partena.be
Gestionnaire comptabilité 02/549.36.07 fax 02/511.58.46 Accountteam4@partena.be
', 'REFERENCE DOSSIER 038573', 0.0000000000000000e+000, 0), (2.3000000000000000e+001, 'Chubb Security Systems', ' ', ' ', 'Chaussée de Bruxelles 307A', '1410', 'Waterloo', 'BELGIQUE', '02/354.96.95', ' ', '02/354.93.39', ' ', '1mois comptant', ' numéro de compte change suite a une fusion de la compagnie 07/05/2007', '720-5400640-80', NULL, 0), (2.4000000000000000e+001, 'ELECTRABEL', ' ', ' ', 'CHAUSSEE D\'IXELLES 133', '1050', 'IXELLES', 'BELGIQUE', '078 / 35 33 33', ' ', ' ', ' ', 'NET', 'ODEURS GAZ 02/274.40.44 OU PANNES 02/274.40.66', '000-0001105-38', NULL, 0), (2.5000000000000000e+001, 'REMUNERATION EQUITABLE', 'OUTSOURCING PARTNERS SA', ' ', 'MARTELAARSLAAN 53-55', '9000', 'GAND', 'BELGIQUE', ' ', ' ', ' ', ' ', ' ', ' ', '210-0497209-39', NULL, 0), (2.6000000000000000e+001, 'SABAM', 'SPRL DROITS D\'AUTEUR-BUREAU DE PERCEPTION DE BXL', ' ', 'AV DE ROODEBEEK 15 /2EME ETAGE', '1030', 'BRUXELLES', 'BELGIQUE', '02/742.24.62', ' ', '02/742.24.60', ' ', ' ', ' ', ' ', NULL, 0), (2.7000000000000000e+001, 'EDINET SPRL', ' ', ' ', 'AV. DE LA SOCIETE NATIONALE 16', '1070', 'BRUXELLES', 'BELGIQUE', '02/522.18.88', '0497/50.97.87', ' ', ' ', 'NET', 'TVA BE449.693.285', '210-0352546-03', 0.0000000000000000e+000, 0), (2.8000000000000000e+001, 'EKLA', 'SPECIALISED CLEANING PRODUCTS', ' ', 'CHAUSSEE DE JETTE 574', '1090', 'BRUXELLES', 'BELGIQUE', '02/424.25.51', ' ', '02/426.69.68', ' ', ' ', 'OU 210-0180420-52', '000-1303201', NULL, 0), (2.9000000000000000e+001, 'F.C.R. SPRL', 'MR.  RUMMENS', 'COMPTABLE', 'SCHEMERINGLAAN 21', '3090', 'OVERIJSE', 'BELGIQUE', '02/687.37.16', '0495/57.37.16', '02/687.37.16', ' ', 'NET', ' ', '230-0100432-57', NULL, 0), (3.1000000000000000e+001, 'SILOOSHOP', 'NETTOYAGE A SEC / MOUJI', ' ', '41, AV DU 11 NOVEMBRE', '1040', 'BRUXELLES', 'BELGIQUE', '02/733.43.05', ' ', '02/733.43.05', ' ', 'NET', ' ', '068-2307247-32', NULL, 0), (3.2000000000000000e+001, 'INTERPARKING SA', ' ', ' ', 'RUE DE L\'EVEQUE 1', '1000', 'BRUXELLES', 'BELGIQUE', '02/218.45.00 FACTURATION', '070/233.291 CONTENTIEUX', ' ', ' ', 'NET', ' ', '210-0201925-23', NULL, 0), (3.3000000000000000e+001, 'MUFFLER SHOP SPRL', 'MR. VAN BEVER', 'DIRECTEUR', 'CHAUSSÉE DE HAL 28', '1640 ', 'RHODE -ST-GENESE', 'BELGIQUE', '02/380.27.34', ' ', ' ', 'MUFFLER-SHOP@SKYNET.BE', ' ', ' ', '293-0344731-48', NULL, 0), (3.4000000000000000e+001, 'MONITEUR BELGE', 'SERVICE PUBLIC FEDERAL JUSTICE', ' ', 'RUE DE LOUVAIN 40-42', '1000', 'BRUXELLES', 'BELGIQUE', '02/552.22.11', ' ', '02/511.01.84', ' ', ' ', ' ', ' ', NULL, 0), (3.5000000000000000e+001, 'MASTERHAND GMBH', 'MR.VAN OVERMEIREN AGENT EN BELGIQUE', ' ', ' ', ' ', 'BRUXELLES', 'BELGIQUE', ' ', ' ', ' ', ' Code BIC  -  GENODEF1JEV', '    IBAN -  DE 50282622541188936050', ' ', '285-0242353-76', NULL, 0), (3.6000000000000000e+001, 'LEROY MERLIN', 'MAGASIN DE BRICOLAGE', ' ', '1301 CHAUSSÉE DE MONS', '1070', 'ANDERLECHT', 'BELGIQUE', '02/555.05.05', ' ', '02/555.05.10', ' ', 'NET', ' ', '310-1079922-10', NULL, 0), (3.7000000000000000e+001, 'FLEX SPRL', ' ', ' ', '12 RUE DE LA LINIÈRE', '1060', 'BRUXELLES', 'BELGIQUE', '02/537.28.35', ' ', '02/537.73.50', ' ', 'NET', 'OU CCP 000-0731416-36', '310-0601997-04', NULL, 0), (3.8000000000000000e+001, 'CASO SC', 'PLAFONNEUR /CARRELEUR', ' ', 'CHAUSSÉE D\'ALSEMBERG 1405', '1180', 'BRUXELLES', 'BELGIQUE', '02/376.42.30', ' ', '02/376.42.30', ' ', 'NET', ' ', '642-0033252-79', NULL, 0), (3.9000000000000000e+001, 'Atos Worldline', ' ', ' ', 'CHAUSSÉE D\'HAECHT 1442', '1130', 'BRUXELLES', 'BELGIQUE', '02/727.88.99', ' ', ' ', ' ', ' ', 'questions commerciales administratives 02 727  88 99
assistance technique terminal banksys 02 727 88 33
transactions Bancontact Mistercash cartes de credit et proton 02 727  88 55
centre d\'autorisation visa mastercard 02 205 80 80
code 10                                           02 205 85 65

', ' PRÉLÈVEMENT AUTOMATIQUE - KEYT', NULL, 0), (4.0000000000000000e+001, 'ELAK ELECTRONICS', ' ', ' ', ' ', ' ', 'BRUXELLES', 'BELGIQUE', '02/512.23.32', ' ', '02/513.96.68', ' ', 'NET', ' ', ' ', NULL, 0), (4.1000000000000000e+001, 'AXA - MR DELCOURT ALAIN', 'MR. DELCOURT ALAIN', 'CONTROLE BUDGÉTAIRE', 'BD DU SOUVERAIN 25', '1170 ', 'BRUXELLES', 'BELGIQUE ', '02/678.61.11', ' 0475/2.52.42', ' ', 'alaindelcourt@skynet.be', ' ', 'MESURES
taille 54 - pantalon 54 96cm tour de taille entre jambe 83 

CHEMISE: cou 44 comfort fit corps L 41/42 sleeve length 63 cm pockets none "e" embroidery standard (sur manchette)
cou 44 comfort fit corps L 41/42 sleeve length 65 cm pockets none "e" embroidery standard (sur manchette)', ' ', 0.0000000000000000e+000, 0), (4.2000000000000000e+001, 'TEXACO LOPEZ', 'STATION ESSENCE', ' ', 'BD INDUSTRIEL 136', '1070', 'ANDERLECHT', 'BELGIQUE', ' ', ' ', '02/520.16.96', ' ', ' ', ' ', '310-1143711-70', NULL, 0), (4.3000000000000000e+001, 'AGF BELGIUM ALLIANZ GROUP', 'ASSUR 2000 SCRL 02/647.06.46', ' ', 'RUE DE LAEKEN 35', '1000', 'BRUXELLES', 'BELGIQUE', '02/214.61.11', ' ', ' ', ' ', ' ', 'ASSURANCE INCENDIE N° DE CONTRAT : UCA020355768', '310-0140765-07', NULL, 0), (4.4000000000000000e+001, 'MONTES JOSE', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' 063-1968095-97', ' ', ' BIC : G K C C B E B B 
numéro de DNI 30170003Y
date d\'expiration de DNI 10/03/2018', ' IBAN :  BE54  0631  9680  9597', 0.0000000000000000e+000, 0), (4.5000000000000000e+001, 'GEORGE\'S  CALZADOS JORDI S.A.', ' ', ' ', 'ANTONIO MAURA 107  - APARTADO 346 -', '07300', 'INCA  -  MALLORCA', 'ESPAGNE', '00.34.971.50.05.59', ' ', '00.34.971.50.00.96', 'GEORGES@GEORGE-SHOES.CON', ' ', 'AGENT:  PATRICK FAURE', 'BANCA MARCH - INTERNACIONAL DIVISION', NULL, 0), (4.6000000000000000e+001, 'PROFELEC S.A.', ' ', ' ', 'PARC INDUSTRIEL DE LA VALLÉE DU HAIN 13À', '1440', 'BRAINE LE CHÀTEAU', ' ', '02/366.94.61', ' ', ' ', ' ', ' ', ' ', ' ', NULL, 0), (4.7000000000000000e+001, 'JET CLEAN & KHOUT SA ', 'ENTREPRISE GENERALE DE CONSTRUCTION', ' ', 'RUE BROYÈRE 25', '1070', 'ANDERLECHT', 'BELGIQUE', '02/346.53.59', '0479/938.246', '02/346.58.08', ' ', ' ', ' ', ' ', NULL, 0), (4.8000000000000000e+001, 'INASTI', 'MR PHILIPPE ETIENNE', ' ', 'PLACE JEAN JACOBS 6', '1000', 'BRUXELLES', 'BELGIQUE', '02/546.4221/4515/4510', ' ', '02/513.04.13', ' ', ' ', ' ', '679-1654507-75', NULL, 0), (4.9000000000000000e+001, 'BELGACOM', ' ', ' ', 'BD DU ROI ALBERT II  27 B', '1030', 'BRUXELLES', 'BELGIQUE', '0800/33/900', ' ', '0800/33/901', ' ', ' ', ' ', '000-1710030-17', NULL, 0), (5.0000000000000000e+001, 'DE GEEST', 'TEINTURIER', ' ', 'RUE DE L\'HOPITAL 37-41', '1000', 'BRUXELLES', 'BELGIQUE', '02/512.59.78', ' ', '02/512.52.59', ' ', ' ', ' ', '000-1497294-02', NULL, 0), (5.1000000000000000e+001, 'DANIA  PELLETTERIA SAS/ CEINTURE ITALY', 'MR. DI DITRI', ' ', 'VIA MENOTTI SERRTI 72', '20098', 'S. GIULIANO MILANESE - MILAN', 'ITALY', '0039/02/984.35.60', ' ', '0039/02/984.16.16', 'info@gutroyal.com', ' ', 'IBAN IT74G0200833380000100449543
SWIFT UNCRITM1268', ' ', 0.0000000000000000e+000, 0);
UNLOCK TABLES;
