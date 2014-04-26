<?php

/*
* Copyright Kaxu-64
* Utilisation autorisé, pensez à citer la source !
* github.com/kaxu64
* Regardez la page comment-utiliser.php pour plus de renseignements
*
*
* Version 1.0
* Fonctions disponible :
*	-- bool estBanni( string )
*	-- bool pseudoLibre ( string )
*	-- int nombreDeJour ( string ) 
*	-- int nombreDeMessage ( string )
*	-- int messagePage ( string )
*	-- string[] getPseudoPage ( string ) 
*	-- string[] getDatePage ( string )
*	-- string[] getHeurePage ( string )
*	-- int nombreDePage( string )
*	-- string[] liensPages( string )
*	-- string[] getMessagePage( string )
*	-- string[][] toutPseudoTopic( $string )
*/

function pseudoLibre($pseudo)
{
					$adressejvc1="http://www.jeuxvideo.com/profil/";
					$adressejvc2=htmlspecialchars(trim(strtolower($pseudo)));
					$adressejvc3=".html";
					$adressejvc = $adressejvc1.$adressejvc2.$adressejvc3;
					
					$curl = curl_init($adressejvc);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
							
					if ($return[204] == "J") // Le pseudo est libre
					{
						return true;
					}
					else // Le pseudo n'est pas libre
					{	
						return false;
					}
}


function estBanni($pseudo)
{

					$adressejvc1="http://www.jeuxvideo.com/profil/";
					$adressejvc2=htmlspecialchars(trim(strtolower($pseudo)));
					$adressejvc3=".html";
					$adressejvc = $adressejvc1.$adressejvc2.$adressejvc3;
					
					$curl = curl_init($adressejvc);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					if (preg_match("/Le pseudo est banni/", $return))
					{
							return true;
					}
					else
					{
							return false;
					}

}

function nombreDeJour($pseudo)
{

					$adressejvc1="http://www.jeuxvideo.com/profil/";
					$adressejvc2=htmlspecialchars(trim(strtolower($pseudo)));
					$adressejvc3=".html";
					$adressejvc = $adressejvc1.$adressejvc2.$adressejvc3;
					
					$curl = curl_init($adressejvc);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					$i = 23;
					$jour = "";
					$pos = strpos($return, 'Membre depuis');
					if ($pos == true)
					{
						while ( $return[$pos+$i] != " ")
						{
						$jour = $jour.$return[$pos+$i];
						$i++;
						}
						
					return str_replace('.','', $jour); 
					}
}

function nombreDeMessage($pseudo)
{

					$adressejvc1="http://www.jeuxvideo.com/profil/";
					$adressejvc2=htmlspecialchars(trim(strtolower($pseudo)));
					$adressejvc3=".html";
					$adressejvc = $adressejvc1.$adressejvc2.$adressejvc3;
					
					$curl = curl_init($adressejvc);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					$i = 2;
					$nbMessageEnvers = '';
					$nbMessage = '';
					$pos = strpos($return, 'messages <span>');
					if ($pos == true)
					{
						while ($return[$pos-$i] != ">")
						
						{
							$nbMessageEnvers = $nbMessageEnvers.$return[$pos-$i];
							$i++;
						}
						$tailleMessage = strlen($nbMessageEnvers);
						
						for ($j=$tailleMessage-1;$j>=0;$j--)
						{
							$nbMessage = $nbMessage.$nbMessageEnvers[$j];
						}
						
						return str_replace('.','', $nbMessage); 
						
					}
					else
					{
						$pos = strpos($return, 'message <span>');
						if ($pos == true)
						{
							while ($return[$pos-$i] != ">")
								{
									$nbMessage = $nbMessage.$return[$pos-$i];
									$i++;
								}
						return $nbMessage;
						}
					}
}

function messagePage($lien)
{
				
					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					$nombreMsg = substr_count($return, 'li class="pseudo"');
					return $nombreMsg;
}

function getPseudoPage($lien)
{
					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					
					$messagePage = messagePage($lien);
					$debut = 3;
					$compteur = 0;
					
					$listePseudo = array();
					while ($compteur != $messagePage)
					{
							$i = 17;
							
							if ( $return[$debut-2] == "=" && $return[$debut-1] == "\"" && $return[$debut] == 'p' && $return[$debut+1] == 's' && $return[$debut+2] == 'e' && $return[$debut+3] == 'u' && $return[$debut+4] == 'd' && $return[$debut+5] == 'o' )
							{ 
						
									$pseudo = '';
									while($return[$debut+$i] != "<")
									{
										
										$pseudo = $pseudo.$return[$debut+$i];
										$i++;
									}
									$listePseudo[$compteur] = $pseudo;
									$compteur++;
							}
							$debut++;
					}
					return $listePseudo;
					
}

function getDatePage($lien)
{
					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					
					$messagePage = messagePage($lien);
					$debut = 0;
					$compteur = 0;
					
					$listeDate = array();
					while ($compteur != $messagePage)
					{
							$i = 18;
							
							if ($return[$debut] == '=' && $return[$debut+1] == '"' && $return[$debut+2] == 'd' && $return[$debut+3] == 'a' && $return[$debut+4] == 't' && $return[$debut+5] == 'e' )
							{ 
						
									$date = '';
									while($return[$debut+$i] != "<" || $return[$debut+$i+1] != "a")
									{
										
										$date = $date.$return[$debut+$i];
										$i++;
									}
									
									if (preg_match("/via mobile/", $date))
									{
										$date2 = $date;
										$date = str_replace('an>via mobile','', $date2); 
										$date3 = $date;
										$date = str_replace('le','', $date3);
									}
									$date = str_replace('Ã','', $date);
									$listeDate[$compteur] = $date;
									$compteur++;
							}
							$debut++;
					}
					return $listeDate;
					
}

function getHeurePage($lien)
{
					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					
					$messagePage = messagePage($lien);
					$debut = 0;
					$compteur = 0;
					
					$listeHeure = array();
					while ($compteur != $messagePage)
					{
							$i = -16;
							
							if ($return[$debut] == 'e' && $return[$debut+1] == 't' && $return[$debut+2] == '=' && $return[$debut+3] == '"' && $return[$debut+4] == 'a' && $return[$debut+5] == 'v' )
							{ 
						
									$heure = '';
									while($return[$debut+$i] != "<" || $return[$debut+$i+1] != "a")
									{
										
										$heure = $heure.$return[$debut+$i];
										$i++;
									}
									
									if (preg_match("/via mobile/", $heure))
									{
										$heure2 = $heure;
										$heure = str_replace('an>via mobile','', $heure2); 
										$heure3 = $heure;
										$heure = str_replace('le','', $heure3);
									}
									$heure = str_replace('Ã','', $heure);
									$listeHeure[$compteur] = $heure;
									$compteur++;
							}
							$debut++;
					}
					return $listeHeure;
					
}

function nombreDePage($lien)
{
					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					
					$compteur = 0;
					$nbPage ='';
					$pos = strpos($return, '<p class="pagination">');
					if ($pos == true)
					{
						while (!($return[$pos+$compteur] == '<' && $return[$pos+$compteur+1] == '/' && $return[$pos+$compteur+2] == 'a' && $return[$pos+$compteur+3] == '>' && $return[$pos+$compteur+4] == '<' && $return[$pos+$compteur+5] == '/' && $return[$pos+$compteur+6] == 'p' && $return[$pos+$compteur+7] == '>'))
						{
						$compteur++;
						}
						
						for ($i = -2; $i<0;$i++)
						{
							if ($return[$pos+$compteur+$i] != ">" && $return[$pos+$compteur+$i] != "Â")
							{
							$nbPage = $nbPage.$return[$pos+$compteur+$i];
							}
						}
						
						if ($nbPage == "»")
						{
							
							$nbPage = "";
							while (!($return[$pos+$compteur] == ">" && $return[$pos+$compteur-1] == "a"))
							{
							$compteur--;
							}
							
							for ($i = -7; $i<-2;$i++)
							{
								if ($return[$pos+$compteur+$i] != ">" && $return[$pos+$compteur+$i] != "<" && $return[$pos+$compteur+$i] != "\"")
								{
								$nbPage = $nbPage.$return[$pos+$compteur+$i];
								}
								
							}
							
						} 
						return $nbPage;
					
					}
					else
					{ 
						return 1;
					}
}

function liensPages( $lien )
{
					$liensPages = array();
					$compteurTiret = 0;
					$stop = 0;
					$debutLien = "";
					$finLien="";
					$j = 0;
					
					for ($i = 0; $i<strlen($lien); $i++)
					{
						if ($compteurTiret == 3 && $stop == 0)
						{
							$debutLien = $debutLien."-";
							$stop++;
						}
						
						if ($lien[$i] == "-")
						{
							$compteurTiret++;
						}
						
						if ($compteurTiret < 3)
						{
							$debutLien = $debutLien.$lien[$i];
						}
						
						if ($compteurTiret > 3)
						{
							$finLien = $finLien.$lien[$i];
						}
							
					}
					
					$nbPages = nombreDePage($lien);
					for ($i =1; $i <= $nbPages; $i++)
					{
					$liensPages[$i-1] = $debutLien.$i.$finLien;
					}
					return $liensPages;
}


function toutPseudoTopic ( $lien )
{

					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					
					$listePseudo = array();
					$lPage  = liensPages( $lien );
					$nbPage = nombreDePage($lien);
					
					for ($j = 0; $j< $nbPage; $j++)
					{
						$listePseudoPage = getPseudoPage($lPage[$j]);
						$msPage = messagePage($lPage[$j]);
						for ($i = 0; $i< $msPage; $i++)
						{
							$listePseudo[$j][$i]= $listePseudoPage[$i];
						}
					}
					return $listePseudo;
}



function getMessagePage($lien)
{
					$curl = curl_init($lien);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
					$return = curl_exec($curl);
					curl_close($curl);
					
					$messagePage = messagePage($lien);
					$debut = 0;
					$compteur = 0;
					
					$listeMessage = array();
					while ($compteur != $messagePage)
					{
							$i = 8;
							if ($return[$debut] == '=' && $return[$debut+1] == '"' && $return[$debut+2] == 'p' && $return[$debut+3] == 'o' && $return[$debut+4] == 's' && $return[$debut+5] == 't' )
							{ 
						
									$message = '';
									while(!($return[$debut+$i] == "<" && $return[$debut+$i+1] == "/" && $return[$debut+$i+2] == "l" && $return[$debut+$i+3] == "i" ))
									{
										
										$message = $message.$return[$debut+$i];
										$i++;
									}
									$listeMessage[$compteur] = $message;
									$compteur++;
							}
							$debut++;
					}
					return $listeMessage;
					
}

?>
