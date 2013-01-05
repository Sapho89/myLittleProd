<html>

<head>
<link rel="stylesheet" type="text/css" href="styleNew.css" />

<script type="text/javascript" src="formArt.js"></script>


</head>

<?php
error_reporting(E_ALL ^ E_NOTICE); //Enlève les notices

?>


<body onLoad="document.forms['formArt'].elements['nom'].focus()">

			
<div id="conteneur">
	
<?php

require_once("menu.php");
?>



<h1 class="soustitre">Nouvel Artiste</h1>


  <form name="formArt" id="inscriptionArt" method="POST" action="inscriptionArt.php" onSubmit="checkForm()">
    
	<div class="champs" >
        
    <div><label for="nom">Nom :</label><input type="text" name="nom" id="nom" onMouseOut="check('nom')"/>&nbsp;<span id="verifNom"></span></div><br/>
	
    <div><label for="prenom">Pr&eacute;nom :</label><input type="text" name="prenom" id="prenom" onMouseOut="check('prenom')"/>&nbsp;<span id="verifPrenom"></span></div><br/>
	
	<div><label for="pseudo">Pseudo :</label><input type="text" name="pseudo" id="pseudo" onMouseOut="check('pseudo')"/>&nbsp;<span id="verifPseudo"></span></div><br/>
		
    <!--<div><label for="naissance">Date de naissance :</label> <input type="date" name="naissance"></div><br/>-->
		
    <div><label for="talent">Talent :</label> 
	<select name="talent" size="1">
		<option value="Chanteur">Chanteur</option>
		<option value="Musicien">Musicien</option>
		<option value="videaste">Vid&eacute;aste</option>
		<option value="Dessinateur">Dessinateur</option>
		<option value="Photographe">Photographe</option>
		<option value="Peintre">Peintre</option>
		<option value="écrivain">&Eacute;crivain</option>
		</select>
	</div>
<br/>
	
	<div><label for="description">Pr&eacute;sentez-vous :</label>
      <textarea name="description" rows="4" cols="40" id="description" onMouseOut="check('description')"/></textarea>
	&nbsp;<span id="verifDescription"></span>
	</div>
	
	<div><label for="mail">Adresse mail :</label> <input type="text" name="mail" id="mail" onMouseOut="check('mail')"/>&nbsp;<span id="verifMail"></span></div><br/>
	
    <div><label for="mdp1">Mot de passe :</label><input type="password" name="mdp1" id="mdp1" onMouseOut="check('mdp1')"/>&nbsp;<span id="verifMdp1"></span></div><br/>

	<center>
	<input type="reset" name="Annuler" value="Annuler" />
    <input type="submit" name="Envoyer" value="Envoyer" onSubmit="return checkForm()"/> 
	</center>
    </div>

</form>

</div>



<?php

require_once("connexion.php");

if( isset($_POST['nom']) && 
	isset($_POST['prenom']) && 
	isset($_POST['pseudo']) && 
	isset($_POST['talent']) && 
	isset($_POST['description']) && 
	isset($_POST['mail']) && 
	isset($_POST['mdp1']) &&
	isset($_POST['Envoyer']))
{
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$pseudo = $_POST['pseudo'];
$updated = $_POST['date_updated'];
$talent = $_POST['talent'];
$description = $_POST['description'];
$mail = $_POST['mail'];
$mdp = $_POST['mdp1'];
}

$addArt = "INSERT INTO artiste 
		(id_artiste, nom, prenom, pseudo, talent, mail, mdp, avatar, date_updated, description) 
		VALUES ('', '$nom', '$prenom', '$pseudo', '$talent', '$mail', '$mdp', '', '', '$description')";

if($result = mysql_query($addArt))
{
echo "Vous etes bien inscrit !";
}
?>

		</div>

</body>

</html>
	