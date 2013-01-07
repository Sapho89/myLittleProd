	<script type="text/javascript">
	//Effacer un commentaire en Jquery
	$(document).ready(function(){
		$(".pane .delete").click(function(){
			var val = confirm("Etes vous sure ?");
			if(val)
			$(this).parents(".pane").animate({ opacity: 'hide' }, "slow");
			return false;
		});
		
		$(".pane .unapprove").click(function(){
		  $(this).parents(".pane").animate({ backgroundColor: "#fff568" }, "fast")
		  .animate({ backgroundColor: "#ffffff" }, "slow")
		  .addClass("spam")
		  return false;
		});
	});
	</script>
	
<?php
echo "<div id='bloc_interaction' >";
echo "<div id='Comm'>";
echo "<h1 class='soustitre'>Commentaires</h1>";

if(isset($_SESSION['id_membre'])) $user =  $_SESSION['id_membre'];
else {$user =  $_SESSION['id_artiste'];}
	
	// Insertion d un commentaire 
	if(isset($_POST['commentaire'])) {
		$commentaire = htmlentities(mysql_real_escape_string($_POST['commentaire']));
		$oeuvre = $_POST['oeuvre'];
		$artiste = $_POST['artiste'];
	
	$req_insert = "INSERT INTO commentaire (id_oeuvre,txt_com,id_artiste,id_membre,date_updated) 
	values('$oeuvre','$commentaire','$artiste','$user',now())";
	mysql_query($req_insert);
	}
	
	/*Ajout d'un commentaire*/
	//onglet permet de différencier l'endroit où est affiché le message. Page de l'oeuvre ou page d'admin de l'artiste
//	if ( (isset($_GET['onglet']) && is_numeric($_GET['onglet']) && isset($_SESSION['fiche_artiste'][$num-1])) || isset($_GET['id_oeuvre'] ) )
	if(isset($_SESSION['id_artiste']) & isset($_GET['id_oeuvre']))
	{
	echo "<div class='pane post'>";
	$src = getSrcAvatar($user,$_SESSION['type']);
/*	if (isset($_SESSION['fiche_artiste'][$num-1]))
			$id_oe = $_SESSION['fiche_artiste'][$num-1]['id_oeuvre']; */
	if(isset($_GET['id_oeuvre']))
			$id_oe = $_GET['id_oeuvre'];
		echo "<img src='$src'	alt='avatar' id='img_mini' width='50px' height='50px'>";
		echo "<div  id='post_text'>
				<form method='post' action='#' >
					<textarea  id='com_area' maxlength='600' rows='5'cols='60' name='commentaire'></textarea>
					<input type='hidden' name='oeuvre' value='$id_oe' />
					<input type='hidden' name='artiste' value='".$_GET['id_artiste']."' />
			        <input type='submit' value='publier' />
				</form>
			<span><a href='#'>".getPseudo($user,$_SESSION['type'])."</a></span>";
		echo "</div>"; 
	}
	echo "</div>";
	
	/*Affich commentaires*/ /*
	if(is_numeric($_GET['onglet']) && isset($_SESSION['fiche_artiste'][$num-1]) ){ //Si affiché sur la page d'une oeuvre dans le profil d'un artiste
		$id_oeuvre = $_SESSION['fiche_artiste'][$_GET["num"]-1]['id_oeuvre'];
		affichComOeuvreById_O($id_oeuvre);}
	else { */
	if(isset($_GET['id_oeuvre'])) { 
		affichComOeuvreById_O($_GET['id_oeuvre']); //Sur un description_...
		} 
	else {
		if ( !(isset($_GET['num'])) OR $_GET['num'] == 'profil' OR $_GET['num'] == 'recap' OR ($id_oeuvre == 0) ) 
			affichComOeuvreById_A($_SESSION["id_membre"]); //Dans le profil d'un membre
	}
	/*}*/
	
	echo "</div>";  //FIN DU BLOC COMMENTAIRE
	
echo "</div>"; //FIN DU BLOC INTERACTION
?>