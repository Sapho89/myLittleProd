<?php

// -------------------
 //  ACCESSEURS
// -------------------

//GET MOY NOTE OEUVRES
function getNote($id_oeuvre)
{
$req = "SELECT avg(note_valeur) FROM note WHERE id_oeuvre = $id_oeuvre";
$res = mysql_query($req);
$ligne = mysql_fetch_assoc($res);
return $ligne['avg(note_valeur)'];
}

//GET PSEUDO
function getPseudo($id_membre,$type)
{
	if($type == 'm') $req = "SELECT pseudo FROM membre WHERE id_membre = $id_membre";	
	else {$req = "SELECT pseudo FROM artiste WHERE id_artiste = $id_membre";}
$res = mysql_query($req);
$ligne = mysql_fetch_assoc($res);
return $ligne['pseudo'];
}

//GET SRC AVATAR
function getSrcAvatar($id_membre,$type)
{
	if($type == 'm') $req = "SELECT avatar FROM membre WHERE id_membre = $id_membre";
	else { $req = "SELECT avatar FROM artiste WHERE id_artiste = $id_membre";}
	$res  = mysql_query($req);
	$ligne = mysql_fetch_assoc($res);
	$src = $ligne['avatar'];
	return $src;
}

//GET DESCRIPTION
function getDescription($id_artiste) //Description valable JUSTE pour les artistes
{
$req = "SELECT description FROM  ARTISTE WHERE id_artiste= $id_artiste";
$res = mysql_query($req);
$ligne = mysql_fetch_assoc($res);
return $ligne['description'];
}


//GET NOMBRE DE FAN
function getFan($id_artiste)
{
$req = "SELECT count(*) FROM fan WHERE id_artiste = $id_artiste";
$res = mysql_query($req);
$ligne = mysql_fetch_assoc($res);
if ($ligne) return $ligne['count(*)'];
else return 0;
}

//GET NOMBRE DE COMMENTAIRES
function getCom($id_artiste)
{
$req = "SELECT count(*) FROM commentaire WHERE id_artiste = $id_artiste";
$res = mysql_query($req);
$ligne = mysql_fetch_assoc($res);
return $ligne['count(*)'];
}

//GET TYPE ID Membre/Artiste ?
function getTypeId($id_membre){
$req_m = "SELECT * FROM membre WHERE id_membre = $id_membre";
$req_a = "SELECT * FROM artiste WHERE id_artiste = $id_membre";

$res_m = mysql_query($req_m);
$res_a = mysql_query($req_a);
if(mysql_num_rows($res_m) != 0) 	return 'm';
else 		return 'a';
}


// -------------------
 //  AFFICHAGE
// -------------------

function conversionToHourFacebook($datePost){
//DATETIME: AAAA-MM-JJ HH:MM:SS
// Pour les dates now() renvoie un datetime et date_updated est un datetime.  
// WARNING !!! Faire attention aux années bissextiles et aux heures d'hiver/ete
//Au 17 mai, cette verification n'as pas encore etais faite. [CECILE]

	//Calcul de la date d'aujourd'hui
	//$datePost = new DateTime($ligne['date_updated']);
	//$datePost2 = new DateTime('2012-05-17 08:38:04');
	
	$dateACeJour = new DateTime('now');
	$tempsDuPost = 0;
	$typeTemps = "mois/annee/jours/....";
	
	//echo "DATE DU POST ",$datePost2->format('Y-m-d H:i:s'),"<br />";
	//echo "DATE DU JOUR ",$dateACeJour->format('Y-m-d  H:i:s'),"<br />";
	
	$interval = date_diff($datePost,$dateACeJour);
	
	//echo $interval->format('%R%y année %m mois %d jour %H heure %I minute %S secondes');
	
	//Affichage du msg de date "Il y XXX jours"
	if (($interval->y) != 0) {$tempsDuPost = $interval->y; $typeTemps = "ans";}
	else {
		if (($interval->m) != 0){$tempsDuPost = $interval->m; $typeTemps = "mois";}
		else { 
			if(($interval->d) != 0){$tempsDuPost = $interval->d; $typeTemps = "jours";}
			else { 
				if(($interval->h) != 0){$tempsDuPost = $interval->h; $typeTemps = "heures";}
				else{ 
					if (($interval->i) != 0){$tempsDuPost = $interval->i; $typeTemps = "minutes";}
					else{$tempsDuPost = $interval->s; $typeTemps = "secondes";}
					}
				}
			}
		}
		$heureFb = "Il y a ".$tempsDuPost." ".$typeTemps; 
		return $heureFb;
}

//AFFICHAGE DE LA LISTE DES OEUVRES TRIES ALPHABETIQUEMENT
function affichOeuvreByIdArtiste($id_artiste){
echo "<h3><mark>Oeuvres de cet artiste</mark></h4>";
$res = "SELECT a.pseudo,`o.id_oeuvre`, `o.id_artiste`, `o.titre`, `o.url`, `o.date_updated`, `o.synopsis`, `o.avis_auteur`, `o.extrait_url`, `o.id_genre1`, `o.id_genre2` 
			FROM `oeuvre` as o,'artiste' as a 
			WHERE `id_artiste` = $id_artiste
			AND 'o.id_artiste' = a.id_artiste;
			
			ORDER BY me.pseudo";
$req = mysql_query($res);

echo "<table>";
while($ligne = mysql_fetch_assoc($req))
{
	echo "<tr>
		<td>".$ligne['titre_oeuvre']."</td>
		</tr>";
}
echo "</table>";
}

//AFFICHAGE DES COMMENTAIRES D'OEUVRES
function affichComOeuvre(){
echo "<h2>//AFFICHAGE DES COMMENTAIRES D'OEUVRES</h2>";
$req = "SELECT * FROM commentaire ORDER by date_updated DESC";
$res = mysql_query($req);

echo "<table>";
while($ligne = mysql_fetch_assoc($res))
{
$type = getTypeId($ligne['id_membre']);
$src = getSrcAvatar($ligne['id_membre'],$type);
	echo "<tr>
		<td><img src='$src' alt='avatar' width='80px' height='80px'/></td>
		<td><strong>".getPseudo($ligne['id_membre'],$type)."</strong></td>
		<td>".$ligne['txt_com']."</td>
		<td>".$ligne['date_updated']."</td>
		</tr>";
}
echo "</table>";
}

//AFFICHAGE DES COMMENTAIRES D'OEUVRES BY ID_ARTISTE (par rapport a la page de l'artiste)
function affichComOeuvreFromId($id_artiste){ 
$req = "SELECT * FROM commentaire WHERE id_membre = $id_artiste ORDER by date_updated DESC";
$res = mysql_query($req);
$titre = "";
	while($ligne = mysql_fetch_assoc($res))
	{
	$req_o = "SELECT titre FROM oeuvre WHERE id_oeuvre = ".$ligne['id_oeuvre']." ORDER by date_updated DESC";
	$res_o = mysql_query($req_o);
	$ligne_o = mysql_fetch_assoc($res_o);
	$heure = conversionToHourFacebook(new DateTime($ligne['date_updated']));
	$type = getTypeId($ligne['id_membre']);
	$src = getSrcAvatar($ligne['id_membre'],$type);
	$id_commentaire = $ligne['id_commentaire'];
	$titre = ($titre == $ligne_o['titre'])? " " : $ligne_o['titre'];
	echo "<div>$titre</div>";
		echo "<div class='pane post' id='$id_commentaire'>
			<img src='$src'		alt='avatar' id='img_mini' width='50px' height='50px'>
			<div id='post_text'>
				<div>".$ligne['txt_com']."</div>
				<span><a href='#'>".getPseudo($ligne['id_membre'],$type)."</a></span>
				<span>$heure</span>
			</div>";
		echo "</div>";
	}
}

function affichComOeuvreById_A($id_artiste){ 
$req = "SELECT * FROM commentaire WHERE id_artiste = $id_artiste ORDER by date_updated DESC";
if ($res = mysql_query($req)){
	while($ligne = mysql_fetch_assoc($res))
	{
	$heure = conversionToHourFacebook(new DateTime($ligne['date_updated']));
	$type = getTypeId($ligne['id_membre']);
	$src = getSrcAvatar($ligne['id_membre'],$type);
	$com = html_entity_decode($ligne['txt_com']);
	$id_commentaire = $ligne['id_commentaire'];
		echo "<div class='pane post' id='$id_commentaire'>
			<img src='$src'		alt='avatar' id='img_mini' width='50px' height='50px'>
			<div id='post_text'>
				<div>".$com."</div>
				<span><a href='#'>".getPseudo($ligne['id_membre'],$type)."</a></span>
				<span>$heure</span>
			</div>";
		echo "</div>";
	}
}
}

//AFFICHAGE DES COMMENTAIRES D'OEUVRES PAR ID_OEUVRE
function affichComOeuvreById_O($id_oeuvre){
$req = "SELECT * FROM commentaire WHERE id_oeuvre = $id_oeuvre ORDER by date_updated DESC";
$res = mysql_query($req);
	
	while($ligne = mysql_fetch_assoc($res))
	{
	$heure = conversionToHourFacebook(new DateTime($ligne['date_updated']));
	$type = getTypeId($ligne['id_membre']);
	$src = getSrcAvatar($ligne['id_membre'],$type);
	$id_commentaire = $ligne['id_commentaire'];
	$com = html_entity_decode($ligne['txt_com']);
		echo "<div class='pane post' id='$id_commentaire'>
			<img src='$src'		alt='avatar' id='img_mini' width='50px' height='50px'>
			<div id='post_text'>
				<div>".$com."</div>
				<span><a href='#'>".getPseudo($ligne['id_membre'],$type)."</a></span>
				<span>$heure</span>
			</div>";
		echo "</div>";
	}
}

//AFFICHAGE DES COMMENTAIRES D'OEUVRES PAR OEUVRE BY ID_MEMBRE
function affichComOeuvreById_M($id_membre){
echo "<h2>//AFFICHAGE DES COMMENTAIRES D'OEUVRES</h2>";
$req = "SELECT * FROM commentaire WHERE id_membre = $id_membre ORDER by date_updated DESC";
$res = mysql_query($req);


echo "<table>";
while($ligne = mysql_fetch_assoc($res))
{
$type = getTypeId($ligne['id_membre']);
$src = getSrcAvatar($ligne['id_membre'],$type);
$com = html_entity_decode($ligne['txt_com']);
	echo "<tr>
		<td><img src=$src alt='avatar' width='80px' height='80px'/></td>
		<td><strong>".getPseudo($ligne['id_membre'],$type)."</strong></td>
		<td>".$com."</td>
		<td>".$ligne['date_updated']."</td>
		</tr>";
}
echo "</table>";
}

//FONCTIONS POUR LES TEXTES
function nbOeuvreById_a($id_artiste){
	$req = "SELECT count(*) FROM Oeuvre where id_artiste=$id_artiste";
	$res = mysql_query($req);
	$ligne = mysql_fetch_assoc($res);
	return $ligne["count(*)"];
}
function affichCompletOeuvreTexteById_o($id_oeuvre){
}
function affichCompletOeuvreTexteById_a($id_artiste){
}

//FONCTION D UPLOAD
function upload_image($FILES,$maxheight,$maxwidth,$size){ 

				if ($_FILES["avatar_local"]["error"] > 0)
				{
					echo "Error: " . $_FILES["avatar_local"]["error"] . "<br />";
					switch($_FILES["avatar_local"]["error"]){
						case UPLOAD_ERR_NO_FILE: echo "Pas de fichier transmis"; break;
						case UPLOAD_ERR_INI_SIZE: echo "UPLOAD_ERR_INI_SIZE : fichier dépassant la taille maximale autorisée par PHP"; break;
						case UPLOAD_ERR_FORM_SIZE: echo "fichier dépassant la taille maximale autorisée par le formulaire"; break;
						case UPLOAD_ERR_PARTIAL: echo "fichier transféré partiellement"; break;
					}
					return NULL;
				}
				else
				{	// Dimension
					$image_size = getimagesize($_FILES['avatar_local']['tmp_name']); //Index 0 = largeur et Index 1 = height 
					//echo "<br />".$image_size[0]." ".$image_size[1];
					$dimension = ( ($image_size[0] <= $maxwidth) AND ($image_size[1] <= $maxheight) )? true: false;
					//Format IE reconnait pjeg et non jpeg
					$extension =  image_type_to_extension($image_size[2],false); //renvoie l'extension correspondant au type MIME donné par getimagesize
					$known_replacements = array( //Type MIME ne correspondant pas vrt à l'extension
						'jpeg' => 'jpg',
						'tiff' => 'tif',
					);
					$extension = '.'.str_replace(array_keys($known_replacements), array_values($known_replacements), $extension);	
					//echo "<br />".$extension;
					switch($extension){
						case ".gif" :{ $type = true; }break;
						case ".jpg" :{ $type = true; }break;
						case ".tif" :{$type = true; }break;
						case ".png" :{ $type = true;} break;
						default: $type = false; break;
					}
					//Poids
					$poids = ($_FILES["avatar_local"]["size"] < $size)? true: false;
					if ($type && $poids  && $dimension) 
					{
						echo "Upload: " . $_FILES["avatar_local"]["name"] . "<br />";
						echo "Type: " . $_FILES["avatar_local"]["type"] . "<br />";
						echo "Size: " . ($_FILES["avatar_local"]["size"] / 1024) . " Kb<br />";
						echo "Stored in: " . $_FILES["avatar_local"]["tmp_name"]."<br />";
						
						if($forme = 'avatar'){
							if(isset($_SESSION['id_membre']) OR isset($_SESSION['id_artiste']) ) {
								if($_SESSION['type'] == 'm'){
									$id = $_SESSION['id_membre'];
									$req = "SELECT avatar FROM MEMBRE WHERE id_membre = ".$_SESSION['id_membre'];}
								else {$req = "SELECT avatar FROM ARTISTE WHERE id_artiste = ".$_SESSION['id_artiste'];
								$id = $_SESSION['id_artiste'];}

							$res = mysql_query($req);
							if($res) $ligne = mysql_fetch_assoc($res);
							if(file_exists($ligne['avatar'])) unlink($ligne['avatar']);
							$url = "avatar/".$id.$extension;
							}
							else {
								do {
								$id = rand (1,1000); //Nom temporaire
								$url = "avatar/"."tmp".$id.$extension;
								}while( file_exists($url) );
							}						
						}
						
						if($forme == 'cover'){
						if(isset($_GET['id_oeuvre'])) {
								$req = "SELECT * FROM OEUVRE WHERE id_oeuvre = ".$_GET['id_oeuvre'];
								$res = mysql_query($req);
								if($res){ $ligne = mysql_fetch_assoc($res_a);
								if(file_exists($ligne['url'] && $ligne['url'] != '' )) unlink($ligne['url']); }
								$id = $_GET['id_oeuvre'];
								$url = "cover/".$id.$extension;
							}
								do {
								$id = rand (1,1000); //Nom temporaire
								$url = "cover/"."tmp".$id.$extension;
								}while( file_exists($url) );	
						}						
						//echo "<br />".$url;
						move_uploaded_file($_FILES["avatar_local"]["tmp_name"],$url);
						

						
						return $url;
					}
					else {
						if(!$dimension) echo "<br />Votre fichier fait plus de $maxwidth px x $maxheight px ! <br />"; 
						if(!$type) echo "<br />Ce n'est pas une image ! <br />";
						if(!$poids) echo "<br />Fichier trop lourd";
						
						return NULL;
					}
				}
}

function upload_video($FILES,$size){

				if ($_FILES["avatar_local"]["error"] > 0)
				{
					echo "Error: " . $_FILES["avatar_local"]["error"] . "<br />";
					switch($_FILES["avatar_local"]["error"]){
						case UPLOAD_ERR_NO_FILE: echo "Pas de fichier transmis"; break;
						case UPLOAD_ERR_INI_SIZE: echo "UPLOAD_ERR_INI_SIZE : fichier dépassant la taille maximale autorisée par PHP"; break;
						case UPLOAD_ERR_FORM_SIZE: echo "fichier dépassant la taille maximale autorisée par le formulaire"; break;
						case UPLOAD_ERR_PARTIAL: echo "fichier transféré partiellement"; break;
					}
					return NULL;
				}
				else
				{	// Dimension
					$image_size = getimagesize($_FILES['avatar_local']['tmp_name']); //Index 0 = largeur et Index 1 = height 
					//echo "<br />".$image_size[0]." ".$image_size[1];
					$dimension = ( ($image_size[0] <= $maxwidth) AND ($image_size[1] <= $maxheight) )? true: false;
					//Format IE reconnait pjeg et non jpeg
					$extension =  image_type_to_extension($image_size[2],false); //renvoie l'extension correspondant au type MIME donné par getimagesize
					$known_replacements = array( //Type MIME ne correspondant pas vrt à l'extension
						'jpeg' => 'jpg',
						'tiff' => 'tif',
					);
					$extension = '.'.str_replace(array_keys($known_replacements), array_values($known_replacements), $extension);	
					//echo "<br />".$extension;
					switch($extension){
						case ".gif" :{ $type = true; }break;
						case ".jpg" :{ $type = true; }break;
						case ".tif" :{$type = true; }break;
						case ".png" :{ $type = true;} break;
						default: $type = false; break;
					}
					//Poids
					$poids = ($_FILES["avatar_local"]["size"] < $size)? true: false;
					if ($type && $poids  && $dimension) 
					{
						echo "Upload: " . $_FILES["avatar_local"]["name"] . "<br />";
						echo "Type: " . $_FILES["avatar_local"]["type"] . "<br />";
						echo "Size: " . ($_FILES["avatar_local"]["size"] / 1024) . " Kb<br />";
						echo "Stored in: " . $_FILES["avatar_local"]["tmp_name"]."<br />";
						
						if(isset($_SESSION['id_membre'])) {
							$req_a = "SELECT avatar FROM ARTISTE WHERE id_artiste = ".$_SESSION['id_membre'];
							$req_m = "SELECT avatar FROM MEMBRE WHERE id_membre = ".$_SESSION['id_membre'];
							echo "<br />".$req;
							$res_a = mysql_query($req_a);
							$res_m = mysql_query($req_m);
							if($res_a OR $res_m) {
								if($res_a) $ligne = mysql_fetch_assoc($res_a);
								if($res_m) $ligne = mysql_fetch_assoc($res_a);
								//echo "<br />existant".$ligne['avatar'];
							if(file_exists($ligne['avatar'])) unlink($ligne['avatar']);
							$id = $_SESSION['id_membre'];}
							else {}
						}
						else {
							$req_a = "SELECT max(id_artiste) FROM ARTISTE";
							$req_m = "SELECT max(id_membre) FROM MEMBRE";
							$res_a = mysql_query($req_a); 
							$res_m = mysql_query($req_m);
							if($res_a) $ligne_a = mysql_fetch_assoc($res_a); else $ligne_a['max(id_artiste)'] = 0;
							if($res_m) $ligne_m = mysql_fetch_assoc($res_m); else $ligne_m['max(id_artiste)'] = 0; 
							if($ligne_a['max(id_artiste)'] > $ligne_m['max(id_membre)']) $id = $ligne_a['max(id_artiste)']++;
							else $id = $ligne_m['max(id_membre)']++;
						}
						$url = "avatar/".$id.$extension;
						//echo "<br />".$url;
						move_uploaded_file($_FILES["avatar_local"]["tmp_name"],$url);
						//echo "<br />Stored in: $url <br />";
						
						return $url;
					}
					else {
						if(!$dimension) echo "<br />Votre fichier fait plus de $maxwidth px x $maxheight px ! <br />"; 
						if(!$type) echo "<br />Ce n'est pas une image ! <br />";
						if(!$poids) echo "<br />Fichier trop lourd";
						
						return NULL;
					}
				}
}

function upload_musique($FILES,$size){}
?>

