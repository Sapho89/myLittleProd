<html>

<head>
<link rel="stylesheet" type="text/css" href="styleNew.css" />

<script type="text/javascript" src="formUser.js"></script>


</head>

<?php
error_reporting(E_ALL ^ E_NOTICE); //Enlève les notices

?>

<body onLoad="document.forms['formUser'].elements['nom'].focus()">

			
<div id="conteneur">
	
<?php

require_once("menu.php");
?>


<h1 class="soustitre">Nouveau Membre</h1> 
   

<form name="formUser" id="inscriptionUser" method="POST" action="inscriptionUser.php" >

<div class="champs" >
        
    <div><label for="nom">Nom :</label><input type="text" name="nom" id="nom" onMouseOut="check('nom')"/>&nbsp;<span id="verifNom"></span></div><br/>
	
    <div><label for="prenom">Pr&eacute;nom :</label><input type="text" name="prenom" id="prenom" onMouseOut="check('prenom')"/>&nbsp;<span id="verifPrenom"></span></div><br/>
	
	<div><label for="pseudo">Pseudo :</label><input type="text" name="pseudo" id="pseudo" onMouseOut="check('pseudo')"/>&nbsp;<span id="verifPseudo"></span></div><br/>

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
	isset($_POST['mail']) && 
	isset($_POST['mdp1']) &&
	isset($_POST['Envoyer'])
	)
{
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$pseudo = $_POST['pseudo'];
$mail = $_POST['mail'];
$mdp = $_POST['mdp1'];
}

$addUser = "INSERT INTO membre
		(id_membre, nom, prenom, pseudo, mail, mdp) 
		VALUES ('', '$nom', '$prenom', '$pseudo', '$mail', '$mdp')";

$result = mysql_query($addUser);

?>

</div>


</body>

</html>

