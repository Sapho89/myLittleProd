<?php
if(isset($_POST['titre']) == FALSE){ //Affiche Formulaire
$onglet = $_GET['onglet'];
$num = $_GET['onglet'];
$req = 	"SELECT `id_oeuvre`, `id_artiste`, `titre`, `url`, `date_updated`, `synopsis`, `avis_artiste`, `id_genre1`, `id_genre2` FROM `oeuvre` 
		WHERE id_artiste = ".$_SESSION['id_artiste'];
$res = mysql_query($req);
$cpt = 0;
$i = 0;
if($res) {
$i = mysql_num_rows($res);  
$_SESSION['fiche_artiste'] = array();
	while($ligne = mysql_fetch_assoc($res)){
		$_SESSION['fiche_artiste'][$cpt] = $ligne;
		$cpt++;
	}
}
echo "<form name='form_upload' method='POST'  action='index.php?page=profil_structure.php&onglet=$onglet' enctype='multipart/form-data' >";

echo "<fieldset>"; /*un fieldset encadre une partie d'une formulaire*/
echo "<legend> Oeuvre N".$_GET['onglet']."</legend>";
echo "<span  style='color:red;font-weight:bold;font-size:0.7em;'>(Tous les champs suivis de * sont obligatoires)</span><br /><br />";

/*Titre de Votre Oeuvre*/
echo "<label for='titre'>Titre de votre Oeuvre</label>&nbsp;&nbsp;";
echo "<input type='texte' id='titre' onMouseOut='checkUpload('titre');' name='titre' value='";if($num <= $i) echo html_entity_decode($_SESSION['fiche_artiste'][$_GET["num"]-1]['titre']); echo "'/>";
echo "<span id='verifTitre'></span>";
echo "<br /><br />";

/*Champ cach� pour garder num_oeuvre si modification d'une oeuvre au lieu de creation*/
	if($num <= $i){ $id_oeuvre = $_SESSION['fiche_artiste'][$_GET["num"]-1]['id_oeuvre'];} else{ $id_oeuvre = 0;}
echo "<input type='hidden' name='id_oeuvre' value=$id_oeuvre />"; 
echo "<input type='hidden' name='num' value='$num'/>";

/*Synopsis*/

echo "<label for='synopsis'>Synopsis</label><br />";
echo "<textarea  onMouseOut='checkUpload(('synopsis')' rows='10'cols='60' name='synopsis'>";if($num <= $i){echo html_entity_decode($_SESSION['fiche_artiste'][$_GET["num"]-1]['synopsis']);} echo "</textarea>";
echo "<br /><span id='verifSynopsis'></span>";

/*Avis Personnel*/
echo "<br /><br /><label for='avis_artiste'>Votre avis personnel a ce sujet. Soyez sincere.</label><br />";
echo "<textarea  onMouseOut='checkUpload(('avis_auteur')' maxlength='600' rows='10'cols='60' name='avis_artiste'>";if($num <= $i) echo html_entity_decode($_SESSION['fiche_artiste'][$_GET["num"]-1]['avis_artiste']); 
echo "</textarea>";
echo "<br /><span id='verifAvis_auteur'></span>";
echo "<br /><br />";

/*Genre*/
	echo "<h3>GENRE</h3>";
	$reqGenre = "SELECT * FROM genre WHERE type = '".$_SESSION['genre']."'"; 
	$resGenre = mysql_query($reqGenre);

	if( $num <= $i )
		$g1 = $_SESSION['fiche_artiste'][$_GET["num"]-1]['id_genre1'];

	echo "<label for='genre1'>Genre 1:</label>&nbsp;&nbsp;";
	echo "<select name='genre1'>";
		while($ligneGenre = mysql_fetch_assoc($resGenre)){
			echo "<option value='".$ligneGenre['id_genre']."'"; if(isset($g1) && $g1 == $ligneGenre['id_genre']) echo "selected"; echo "/>".$ligneGenre['genre']."</option>";
			}
	echo "</select>&nbsp;&nbsp;";
	if( $num <= $i )
		$g2 = $_SESSION['fiche_artiste'][$_GET["num"]-1]['id_genre2'];
	$resGenre = mysql_query($reqGenre);
	echo "<br /><label for='genre2'>Genre 2:</label>&nbsp;&nbsp;";
	echo "<select name='genre2'>";
	while($ligneGenre = mysql_fetch_assoc($resGenre)){
		echo "<option value='".$ligneGenre['id_genre']."'"; if(isset($g2) && $g2 == $ligneGenre['id_genre']) echo "selected"; echo "/>".$ligneGenre['genre']."</option>";
		}
	echo "</select><br /><br />";



/*Photo de Couverture [Obligatoire]*/
if($num <= $i)
{$url =  $_SESSION['fiche_artiste'][$_GET["num"]-1]['url'];}

echo "<br /><label for='cover'>Photo de Couverture</label> <br />";
echo "<img id='cover_photo' src='";if(isset($url))echo $url; echo"' width='250px' height='350px' /><br />";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='1024*1000*1000*1000' />"; 
echo "<input type='file' onMouseOut='checkUpload(('url')' name='avatar_local' img='cover' value='";if(isset($url)) echo $url;echo"'/> <br />
<span  style='color:red;font-weight:bold;'>*</span>
<span id='verifUrl'>Votre photo de couverture doit être un .jpg, .png ou .gif</span>
<br />";

if($_SESSION['genre'] == 'video'){?>
<!--	<label for='video' >Veuillez uploader une video d''un des types suivants [mp4, ogg, webm, flv]<br /><br /></label>
	<input type='hidden' name='MAX_FILE_SIZE' value='1024*1000*1000' /> <!-- Max données transporté par le formulaire -->
<!--	<input type='file' id='avatar_local' name='video' />
-->
	<?php
}

/*Extrait ou Oeuvre Complète [Non Obligatoire]*/
/*echo "<h3> PLANCHES  [Sous la forme d'une url uploade sur un hebergeur d'images]</h3>";

echo "<br /><label for='planche1'>PLANCHE 1</label><br />";
echo "<input type='name' name='planche1' /><br />";

echo "<br /><label for='planche2'>PLANCHE 2</label><br />";
echo "<input type='name' name='planche2' /><br />";

echo "<br /><label for='planche3'>PLANCHE 3</label><br />";
echo "<input type='name' name='planche3' /><br />";
*/
echo "</fieldset>";
echo "<input type='reset' value='annuler' />";
echo "<input type='submit' value='envoyer' />"; //onSubmit='verifFormUpload();
echo "</form>";
//Quand on cliques sur envoyer, le js vérifies tous les champs. Ils sont TOUS obligatoires sauf upload extrait
}
else {
 //"Compiler" le formulaire puis renvoyer le texte.
 //Formulaire envoy�
	if ($_POST['id_oeuvre'] == 0) //CREATION d'une oeuvre
	{
		if(	isset($_POST['titre']) && isset($_POST['synopsis']) && 
		isset($_POST['avis_artiste'])   && 
		isset($_POST['genre1']) && isset($_POST['genre2'])
		&& isset($_FILES['avatar_local'])		) {
	
	$extension = ""; $url_son="";
	
	$titre =  htmlentities(mysql_real_escape_string($_POST['titre']));
	$synopsis =  htmlentities(mysql_real_escape_string($_POST['synopsis']));
	$avis_artiste =  htmlentities(mysql_real_escape_string($_POST['avis_artiste']));
	
	$id_artiste = $_SESSION['id_artiste'];
	
	$id_genre1 = $_POST['genre1'];
	$id_genre2 = $_POST['genre2'];
	
	$cover = upload_image($FILES['avatar_local']['name'],1000,1500,1000 * 1024,'cover'); //Dimension/Format/Poids  modifiables
	if($_SESSION['genre'] == 'video') {
		$extension = $FILES['video']['type'];
		$url_son = upload_video($FILES['video']['name'],100 * 1024 * 1024); //Dimension/Format/Poids  modifiables
	}
	/* A TRAITER PLUS TARD
	$planche = $_POST['planche1'];
	$planche = $_POST['planche2'];
	$planche = $_POST['planche3'];*/
		
	/*
	$req  = "SELECT id_oeuvre FROM  `oeuvre` ORDER BY id_oeuvre DESC";
	$res = mysql_query($req);
	$ligne = mysql_fetch_assoc($res);
	
	if(mysql_num_row($res) == 0) $id_oeuvre = 1;
	else { $id_oeuvre =  1 + $ligne['id_oeuvre']; } */
   
	$req_modif3 = "INSERT INTO oeuvre (id_artiste,titre,url,url_son,extension,date_updated,synopsis, avis_artiste,id_genre1, id_genre2)
				VALUES ('$id_artiste','$titre','$cover','$url','$url_son','$synopsis','$avis_artiste',$id_genre1,$id_genre2)";						
	//echo $req_modif3;
	mysql_query($req_modif3);
	
		header("location:index.php?page=profil_structure.php&onglet=".$_POST['num']."");
		}
		else { // Une des données est manquante
		echo "Une des données est manquante <br /> Vous allez être redirigé dans 3 secondes vers la page principale";
		echo "<meta http-equiv='refresh' content='3; url=index.php?page=profil_structure'>";
		}
	}
	else{//MODIFICATION d'un oeuvre existante
	if(	isset($_POST['titre']) && isset($_POST['synopsis']) && 
	    isset($_POST['avis_artiste'])   && 
		isset($_POST['genre1']) && isset($_POST['genre2'])
		&& isset($_FILES['avatar_local']) ) {
		
	$extension = "";
	$url_son="";
	
	$titre = htmlentities(mysql_real_escape_string($_POST['titre']));
	$synopsis = htmlentities(mysql_real_escape_string($_POST['synopsis']));
	$avis_artiste = htmlentities(mysql_real_escape_string($_POST['avis_artiste']));
	
	$id_genre1 = $_POST['genre1'];
	$id_genre2 = $_POST['genre2'];
	
	$cover = upload_image($FILES['avatar_local']['name'],1000,1500,1000 * 1024,'cover'); //Dimension/Format/Poids  modifiables
	if($_SESSION['genre'] == 'video') {
		$extension = $FILES['video']['type'];
		$url_son = upload_video($FILES['video']['name'],100 * 1024 * 1024); //Dimension/Format/Poids  modifiables
	}
	/* A TRAITER PLUS TARD
	$planche = $_POST['planche1'];
	$planche = $_POST['planche2'];
	$planche = $_POST['planche3'];*/
	
	$id_oeuvre = $_POST['id_oeuvre'];
	$req_modif3 = "UPDATE oeuvre SET titre = '$titre',url = '$cover', url_son = '$url_son',extension = '$extension', 
		synopsis = '$synopsis', avis_artiste = '$avis_artiste', id_genre1 = $id_genre1,id_genre2 = $id_genre2	
					   WHERE id_oeuvre = $id_oeuvre";	
	echo $req_modif3;
	mysql_query($req_modif3);
	
		//header("location: profil_artiste_structure.php?onglet=".$_POST['num']);
		}
		else { // Une des données est manquante
		echo "Une des données est manquante <br /> Vous allez être redirigé dans 3 secondes vers la page principale";
		echo "<meta http-equiv='refresh' content='3; url=index.php?page=profil_structure'>";}
	}
} //Fin du Else du formulaire de saisie/mise � jour DataBase

?>