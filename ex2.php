<?php
error_reporting(E_ALL);
function login_and_post( $login_user, $login_pass, $login_url, $visit_url, $http_agent, $cookie_file ){
	/* SE CONNECTER */
	if( !function_exists( 'curl_init' ) || ! function_exists( 'curl_exec' )){
		$m = 'cUrl is not vailable in you PHP server.';
		echo $m;
	}
	$data = 'log='. $login_user .'&pwd=' . $login_pass . '&wp-submit=Log%20In&redirect_to=' . $visit_url;
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $login_url );
	curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie_file );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_USERAGENT, $http_agent );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_REFERER, $login_url );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt( $ch, CURLOPT_POST, 1);
	$content = curl_exec ($ch);
	curl_setopt( $ch, CURLOPT_URL, 'http://playmobitch.com/recrutement/?p=1#comments' );
	$content = curl_exec ($ch);
	echo $content;
	
	
	
	/*
		J'ai tenté de remplacer le message du commentaire par
		une des phrases générée aléatoirement dans l'exercice 1.
		Mais ça ne s'affiche pas correctement.
		
		Voici en commentaire ce que j'avais fait :
		
		$chaine = "{Ce matin|Ce midi|Ce soir} il fait {beau|moche|gris|soleil} à {Paris|Marseille|Toulouse}.";
	
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
		$sentence = sentence($chaine);
		
		$post_data['comment'] = '\''.$sentence.'\''; //cette ligne remplace la ligne 60
	*/
	
	/* POSTER UN COMMENTAIRE */
	$url="http://playmobitch.com/recrutement/wp-comments-post.php"; 
	$post_data['comment'] = 'Hey MAIS CA FONCTIONNE';
	$post_data['submit'] = 'Laisser un commentaire';
	$post_data['comment_post_ID'] = '1';
	$post_data['comment_parent'] = '0';

	foreach ( $post_data as $key => $value) 
	{
		$post_items[] = $key . '=' . $value;
	}
	$postdata = implode ('&', $post_items);

	$ch = curl_init($url);
	curl_setopt ($ch, CURLOPT_URL, $url); 
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US;         rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); 
	curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); 
	curl_setopt ($ch, CURLOPT_REFERER, $url); 
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
	curl_setopt ($ch, CURLOPT_POST, 1); 
	$result = curl_exec ($ch); 
	echo $result;
	curl_close($ch);
}

$login_user = 'aldana.antony';
$login_pass = '4gjjw2A0KjIe';
$login_url = 'http://playmobitch.com/recrutement/wp-login.php';
$visit_url = urlencode( 'hhttp://playmobitch.com/recrutement/wp-admin/profile.php' );
$cookie_file = '/cookie.txt';
$http_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6';

login_and_post( $login_user, $login_pass, $login_url, $visit_url, $http_agent, $cookie_file );

/*
	Je n'avais jamais travaillé avec curl, je ne connaissais d'ailleurs pas son utilisation ni son fonctionnement.
	J'ai passé énormément de temps à chercher comment l'utiliser et l'adapter pour le site qui était en exemple.
	Mais la partie qui m'a pris le plus de temps concerne l'étape de poste du commentaire. En effet, j'ai parcouru
	une 40aine de sites et regardé plusieurs vidéos concernant ce procédé, sans pour autant avoir un résultat concluant.
	Je suis finalement parvenu au résultat escompté en mettant une ligne en commentaire... Au bout de plus de 5h...
	
	TEMPS ESTIMÉ: +/- 5 h
*/
?>