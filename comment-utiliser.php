<?php 

/* 
*
* L'api fournit vous permet de récuperer diverse données provenant du site jeuxvideo.com 
* Elle n'utilise que les informations rendues publiques par le site, c'est à dire les pseudos, les messages, les nombre de posts etc ...
* Attention l'api s'adresse à un public ayant un minimum de connaissance en PHP et en HTML .

Pour utiliser l'api, il faut d'abbord l'inclure dans votre page principale:

*/

require 'api.php' ;

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
*	 nombreDePage( string )
*	 liensPages( string )
*	 getMessagePage( string )
*	 toutPseudoTopic( $string )
*
* Toutes la plupart des fonctions retournent quelque chose, pensez donc à attribuer une variable à chaque fonction
* Exemple :
*/

$pseudo = "Kaxu-64";
$messageDeKaxu = $nombreDeMessage($pseudo);
echo $messageDeKaxu // Affiche le nombre de message posté par l'utilisateur Kaxu

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
  echo "Le pseudo est banni :'( ";
}
else
{
  echo "Le pseudo n'est pas banni !";
}

/*

* ---- pseudoLibre(string) ----
* Prends en parametre une chaine de caractere ( un pseudo ) et retourne une valeur booléenne. Vrai si le pseudo est libre, faux si le pseudo existe déja
* L'utilisation de cette fonction est identique à " estBanni() "


