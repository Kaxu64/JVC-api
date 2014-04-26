<?php 

/* 
*
* L'api fournit vous permet de récuperer diverse données provenant du site jeuxvideo.com 
* Elle n'utilise que les informations rendues publiques par le site, c'est à dire les pseudos, les messages, les nombre de posts etc ...
* Attention l'api s'adresse à un public ayant un minimum de connaissance en PHP et en HTML .

Pour utiliser l'api, il faut d'abbord l'inclure dans votre page principale:

*/

include 'api.php' ;

/*


*  Une fois incluse, vous pouvez faire appel à toutes les fonctions de celle-ci, c'est à dire :
*  estBanni( string )
*	 pseudoLibre ( string )
*	 nombreDeJour ( string ) 
*	 nombreDeMessage ( string )
*	 messagePage ( string )
*	 getPseudoPage ( string ) 
*	 getDatePage ( string )
*	 getHeurePage ( string )
*	 getMessagePage( string )
*	 nombreDePage( string )
*	 liensPages( string )
*	 toutPseudoTopic( $string )
*
* Toutes la plupart des fonctions retournent quelque chose, pensez donc à attribuer une variable à chaque fonction
* Exemple :
*/

$pseudo = "Kaxu-64";
$messageDeKaxu = nombreDeMessage($pseudo);
echo "$pseudo a posté $messageDeKaxu messages<br>"; // Affiche le nombre de message posté par l'utilisateur Kaxu

/* 

* Voici un bref descriptif des fonctions proposées:
* 
* ---- estBanni ( string ) ----
* Prends en parametre une chaine de caractère ( un pseudo ) et retourne une valeur booléenne ( vrai ou fausse ) en fonction de l'état du pseudo ( vrai pour banni, faux pour non-banni 
* Exemple:
*/ 

$pseudo = "Kaxu-64";
if (estBanni($pseudo))
{
  echo "Le pseudo est banni :'( <br>";
}
else
{
  echo "Le pseudo n'est pas banni !<br>";
}

/*

* ---- pseudoLibre(string) ----
* Prends en parametre une chaine de caractere ( un pseudo ) et retourne une valeur booléenne. Vrai si le pseudo est libre, faux si le pseudo existe déja
* L'utilisation de cette fonction est identique à " estBanni() "
*
* ---- nombreDeJour (string) ----
* Prends en parametre une chaine de caractere ( un pseudo ) et retourne un entier correspondant au nombre de jour d'ancienneté du pseudo.
* Exemple:
*/

$pseudo = "Kaxu-64";
$jourDePseudo = nombreDeJour($pseudo);
echo "$pseudo a $jourDePseudo jours d'ancienneté<br><br>"; 
// Affichera " Kaxu a 1655 jours d'ancienneté "

/*
* ---- nombreDeMessage (string) ----
* Prends en parametre une chaine de caractere ( un pseudo ) et retourne un entier correspondant au nombre de messages postés par le pseudo.
* L'utilisation est la meme que la fonction " nombreDeJour() "
*
*
* ---- messagePage (string) ----
* Prends en parametre une chaine de caractere ( un lien d'un topic ) et retourne un entier correspondant au nombre de messages de la page ( le maximum etant 20 ).
* Exemple:
*/

$lien = 'http://www.jeuxvideo.com/forums/1-1000021-428447-1-0-1-0-les-plus-gros-pseudos-de-jv-com.htm';
$nbMessageDeLaPage = messagePage($lien);
echo "La page $lien comporte $nbMessageDeLaPage messages <br>"; // Affiche 20


/*
* ---- getPseudoPage (string) ----
* Prends en parametre une chaine de caractere ( un lien d'un topic ) et retourne un tableau de chaines de caracteres contenant chaque pseudo ayant posté sur la page. Si un membre a posté plusieurs fois son pseudo apparait plusieurs fois dans le tableau.
* Attention le tableau commence à la position 0 !
* Le premier post de la page se trouve donc en position 0, le second en position 1 etc ...
* Les fonctions getDatePage() et getHeurePage() fonctionnent de la même façon, elle apparaissent dans l'exemple.
* Exemple:
*/

$listePseudo = getPseudoPage('http://www.jeuxvideo.com/forums/1-1000021-428447-1-0-1-0-les-plus-gros-pseudos-de-jv-com.htm');
$listeHeurePost = getHeurePage('http://www.jeuxvideo.com/forums/1-1000021-428447-1-0-1-0-les-plus-gros-pseudos-de-jv-com.htm');
$nbMessageDeLaPage = messagePage($lien);
for ( $i = 0; $i< $nbMessageDeLaPage; $i++)
{
	$numDuPost = $i+1;
	$pseudo = $listePseudo[$i];
	$heure = $listeHeurePost[$i];
	echo "Le post numero $numDuPost a été posté par $pseudo à $heure<br>";
}
/*
*
* ---- nombreDePage (string) ----
* Prends en parametre une chaine de caractere ( un lien d'un topic ) et retourne un entier correspondant au nombre de page du topic
* Exemple:
*/

$lien = 'http://www.jeuxvideo.com/forums/1-1000021-428447-1-0-1-0-les-plus-gros-pseudos-de-jv-com.htm';
$nbDePage = nombreDePage($lien);
echo "La topic $lien possede $nbDePage pages <br>"; // Affiche 20

/*
*
* ---- liensPage (string) ----
* Prends en parametre une chaine de caractere ( un lien d'un topic ) et retourne un tableau de chaines de caracteres comportant les liens de chaque pages du topic:
* L'element du tableau en position 0 correspond au lien de la premiere page, l'element 1 au lien de la seconde page, etc ...
* Exemple:
*/

$lien = "http://www.jeuxvideo.com/forums/1-1000021-428447-1-0-1-0-les-plus-gros-pseudos-de-jv-com.htm";
$liens = liensPages ($lien);
for ($i = 0; $i<10;$i++) // Je n'affiche que les dix premieres pages, charger les 900+ pages serait un peu trop long
{
		echo "Page ";
		echo $i+1;
		echo " : <a href='";
		echo $liens[$i];
		echo "'>";
		echo $liens[$i]."<br>";
		echo "</a>";
}

/*
*
* ---- toutPseudoTopic (string) ----
* Prends en parametre une chaine de caractere ( un lien d'un topic ) et retourne un tableau à deux dimensions de chaines de caracteres comportant les pseudos de chaques membre ayant posté sur le topic.
* Si notre variable s'appelle $tableau , alors:
* $tableau[0][0] correspond à l'auteur du topic
* $tableau[0][2] correspond à la deuxieme personne à avoir répondu à l'auteur
* $tableau[1][0] correspond au premier message de la deuxieme page
* et ainsi de suite ...
* Exemple:
*/

$lien = "http://www.jeuxvideo.com/forums/1-1000021-2141393-1-0-1-0-il-y-a-des-pseudos-relaches-apres-plusie.htm";
$nbPage = nombreDePage($lien);
$listePseudo = toutPseudoTopic ($lien);
echo "<br><br>Topic: $lien <br>" ;
for ($j = 0;$j<=$nbPage-1;$j++)
{
	$numPage = $j+1;
	for ($i=0;$i<=20;$i++)
	{
		if (isset($listePseudo[$j][$i]))
		{
		$numPost = $i+1;
		echo $listePseudo[$j][$i]." a posté le post numero $numPost en page $numPage<br>";
		}
	}
}
?>

