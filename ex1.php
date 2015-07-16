<?php
	$chaine = "{Ce matin|Ce midi|Ce soir} il fait {beau|moche|gris|soleil} � {Paris|Marseille|Toulouse}.";
	$chaine2 = "{Aujourd'hui|Hier|Mercredi|Samedi} j'ai {mang�|�cras�|cuit|lanc�|crach�} {une pomme|une banane|une cerise|un caillou} alors qu'il faisait {beau|moche|gris|soleil} � {Paris|Marseille|Toulouse}.";
	$chaine3 = "{Aujourd'hui|Hier|Mercredi|Samedi} {j'ai {mang�|�cras�|cuit|lanc�|crach�} {une {pomme|banane|cerise}|un {caillou|tric�ratops|�uf}}|il fait {beau|moche|gris|soleil} � {Paris|Marseille|Toulouse}}.";
	
	function sentence($chaine) {
		$matches = array();
		preg_match_all('#\{.*?\}|[^ ]+#', $chaine, $matches);
		
		foreach ($matches[0] as $word) {
			$m = array();
			if (preg_match('#^\{(.*)\}$#', $word, $m)) {
				$chaine = explode("|",htmlspecialchars($m[1]));
				echo $chaine[rand(0,count($chaine)-1)];
			} else {
				echo htmlspecialchars($word);
			}
			echo ' ';
		}
		echo "<br />";
	}
	
		function sentenceIncepionBrackets($chaine) {
		$matches = array();
		preg_match_all('#\{.*?\}|[^ ]+#', $chaine, $matches);
		
		foreach ($matches[0] as $word) {
			$m = array();
			if (preg_match('#^\{(.*)\}$#', $word, $m)) {
				$chaine = explode("|",htmlspecialchars($m[1]));
				$s = array();
				if (preg_match('#^\{(.*)\}$#', $word, $s)) {
					$chaine = explode("|",htmlspecialchars($s[1]));
					echo $chaine[rand(0,count($chaine)-1)];
				} else {
				echo $chaine[rand(0,count($chaine)-1)];
				}
			} else {
				echo htmlspecialchars($word);
			}
			echo ' ';
		}
		echo "<br />";
	}
	
	function sentenceAll($chaine) {
		$matches = array();
		preg_match_all('#\{.*?\}|[^ ]+#', $chaine, $matches);
		
		foreach ($matches[0] as $word) {
			$m = array();
			$i=0;
			while($i <= count($chaine)){
				if (preg_match('#^\{(.*)\}$#', $word, $m)) {
					$chaine = explode("|",htmlspecialchars($m[1]));
					echo $chaine[$i];
				} else {
					echo htmlspecialchars($word);
				}
				echo ' ';
				$i++;
			}
		}
		echo "<br />";
	}
	
	sentence($chaine);
	sentence($chaine2);
	sentence($chaine3);
	
	sentenceIncepionBrackets($chaine3);
	
	sentenceAll($chaine);
	
	/*
		Dans un premier temps, je me suis occup� de trouver les d�limiteurs {} dans la chaine pour pouvoir s�parer les mots.
		Ensuite, je n'ai plus qu'� d�couper les groupes de mots s�par�s par un pipe pour les stocker dans une variable tableau.
		Et pour finir, je fais appel � cette variable en lui passant un indice al�atoire compris entre 0 et �a taille - 1.		
	*/
	
	/* TEMPS ESTIM� : +/- 1 h (je n'ai pas tout de suite trouv� la fonction pour trouver deux d�limiteurs et j'ai eu du mal � saisir la syntaxe de l'expression r�guli�re permettant de s�parer les groups de mots)
?>
