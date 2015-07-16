<?php
session_start();  
if (!isset($_SESSION['email'])) { 
   header ('Location: index.php'); 
   exit();  
}
$session_email = mysql_escape_string($_SESSION['email']);
$base = mysql_connect ('sql.free.fr', '*****', '****');  
mysql_select_db ('a_j_transports', $base);
?>

<!DOCTYPE html> 
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<title>Gestion des feuilles de route</title>
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header">
				<a href="membre.php" data-icon="home">Retour</a>
				<h1>Gestion des feuilles de route de EXAPAQ</h1>
				<a href="ajout_exa.php" data-icon="plus">Ajouter une tournée</a>
			</div><!-- /Entete de la page -->
			<div data-role="content">
			<form action="exa_admin.php" method="post" data-ajax="false">
				<fieldset class="ui-grid-b"> 
					<div class="ui-block-a">
						<label for="select-choice-1" class="select"></label>
							<select name="mois" id="select-choice-1">
							<?php
							$reponse = mysql_query('SELECT DISTINCT MONTH(Date_liv) AS mois FROM `tournee_exa` ORDER BY mois');
							while($donnees = mysql_fetch_array($reponse))
							{
							?>
								<option VALUE="<?php echo $donnees['mois'];?>"><?php echo $donnees['mois'];?></option>
							<?php
							}
							?>
							</select>
					</div>
					<div class="ui-block-b">
						<label for="select-choice-1" class="select"></label>
							<select name="annee" id="select-choice-1">
								<?php
								$reponse = mysql_query('SELECT DISTINCT YEAR(Date_liv) AS annee FROM `tournee_exa` ORDER BY annee');
								while($donnees = mysql_fetch_array($reponse))
								{
								?>
									<option VALUE="<?php echo $donnees['annee'];?>"><?php echo $donnees['annee'];?></option>
								<?php
								}
								?>
							</select>
					</div>
					<div class="ui-block-c">
						<label for="afficher"></label><input type="submit" name="afficher" id="afficher" value="Afficher" data-theme="b" />
					</div>
				</fieldset>
			</form>
			<?php
			if (isset($_POST['afficher']) && $_POST['afficher'] == 'Afficher') { 
				$result2 = mysql_query('SELECT DISTINCT Numero FROM tournee_exa ORDER BY Numero');
				while($row= mysql_fetch_array($result2)) {
					 $tblNumero[] = $row['Numero'];
				}
				/*ICI*/
				$result = mysql_query('SELECT Numero, Nb_pt_liv, Pickup, Date_liv FROM tournee_exa WHERE MONTH(Date_liv) = "'.mysql_escape_string($_POST['mois']).'" AND YEAR(Date_liv) = "'.mysql_escape_string($_POST['annee']).'" ORDER BY Date_liv');
				while ($row = mysql_fetch_assoc($result)) {
					 $data[$row['Date_liv']][$row['Numero']] = array('points'=>$row['Nb_pt_liv'], 'pickup'=>$row['Pickup']);
				}
				echo '<table id="gradient-style" summary="Meeting Results"><tr><th scope="col">Points - Ramasses</th>';
				foreach ($tblNumero as $numero) {
				   echo '<th scope="col">' . $numero . '</th>';
				   $i = $i+1;
				}
				echo '</tr>';
				if (is_array($data)){
					foreach($data as $date=>$data_numeros) {
						echo '<tr><th scope="col">'. $date . '</th>';
						foreach ($tblNumero as $numero) {
							 if (isset($data_numeros[$numero])) {
									$points = $data_numeros[$numero]['points'];
									$pickup = $data_numeros[$numero]['pickup'];
							  }
							 else {
									$points = '';
									$pickup = '';
							 }
							 echo '<td>' . $points . ' - ' . $pickup . '</td>';
						 }
						 echo '</tr>';
					}
				}
				echo '<tr><th scope="col">Total</th>';
				$result2 = mysql_query('SELECT DISTINCT Numero FROM tournee_exa ORDER BY Numero');
				while($row= mysql_fetch_array($result2)) {
					$num = $row['Numero'];
					$mois = mysql_escape_string($_POST['mois']);
					$annee = mysql_escape_string($_POST['annee']);
					$nb_pt="SELECT SUM(Nb_pt_liv) AS nb_pt, SUM(Pickup) AS pick FROM tournee_exa WHERE Numero ='$num' AND MONTH(Date_liv) = '$mois' AND YEAR(Date_liv) = '$annee' ORDER BY Numero";
					$req_nb_pt=mysql_query($nb_pt);
					$tab_nb_pt=mysql_fetch_array($req_nb_pt);
					echo '<th  scope="col">'.$tab_nb_pt["nb_pt"].' - '.$tab_nb_pt["pick"].'</th>';
				}
				echo '</tr></table>';
			} else { 
				$result2 = mysql_query('SELECT DISTINCT Numero FROM tournee_exa ORDER BY Numero');
				while($row= mysql_fetch_array($result2)) {
					 $tblNumero[] = $row['Numero'];
				}
				/*ICI*/
				$result = mysql_query('SELECT Numero, Nb_pt_liv, Pickup, Date_liv FROM tournee_exa WHERE MONTH(Date_liv) = MONTH(Now()) AND YEAR(Date_liv) = YEAR(Now()) ORDER BY Date_liv');
				while ($row = mysql_fetch_assoc($result)) {
					 $data[$row['Date_liv']][$row['Numero']] = array('points'=>$row['Nb_pt_liv'], 'pickup'=>$row['Pickup']);
				}
				echo '<table id="gradient-style" summary="Meeting Results"><tr><th scope="col">Points - Ramasses</th>';
				foreach ($tblNumero as $numero) {
				   echo '<th scope="col">' . $numero . '</th>';
				   $i = $i+1;
				}
				echo '</tr>';
				foreach($data as $date=>$data_numeros) {
					echo '<tr><th scope="col">'. $date . '</th>';
					foreach ($tblNumero as $numero) {
						 if (isset($data_numeros[$numero])) {
								$points = $data_numeros[$numero]['points'];
								$pickup = $data_numeros[$numero]['pickup'];
						  }
						 else {
								$points = '';
								$pickup = '';
						 }
						 echo '<td>' . $points . ' - ' . $pickup . '</td>';
					 }
					 echo '</tr>';
				}
				echo '<tr><th scope="col">Total</th>';
				$result2 = mysql_query('SELECT DISTINCT Numero FROM tournee_exa ORDER BY Numero');
				while($row= mysql_fetch_array($result2)) {
					$num = $row['Numero'];
					$nb_pt="SELECT SUM(Nb_pt_liv) AS nb_pt, SUM(Pickup) AS pick FROM tournee_exa WHERE Numero ='$num' AND MONTH(Date_liv) = MONTH(Now()) AND YEAR(Date_liv) = YEAR(Now()) ORDER BY Numero";
					$req_nb_pt=mysql_query($nb_pt);
					$tab_nb_pt=mysql_fetch_array($req_nb_pt) ;
					echo '<th  scope="col">'.$tab_nb_pt["nb_pt"].' - '.$tab_nb_pt["pick"].'</th>';
				}
				echo '</tr></table>'; 
			}
			mysqli_close($base);
			?>
			</div>
			<div data-role="footer">
				<div class="ui-grid-b">
					<div class="ui-block-a"></div>
					<div class="ui-block-b"><a href="exa.php" data-role="button" data-type="horizontal">Mes tournées</a><h4 style="text-align:center">&copy; Aldana - Antony 2013</h4></div>
					<div class="ui-block-c"></div>
				</div><!-- /grid-b -->
			</div><!-- /Pied de page -->

		</div>
	</body>
</html>