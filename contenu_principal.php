<?php

if($_GET['page'] != "")
{
	if($_GET['page'] == 'video')
	{
	$_SESSION['page'] = "video";
	include_once("affichage_oeuvres.php");
	}
	else if($_GET['page'] == 'image')
	{
	$_SESSION['page'] = "image";
	include_once("affichage_oeuvres.php");
	}
	else if($_GET['page'] == 'litterature')
	{
	$_SESSION['page'] = "litterature";
	include_once("affichage_oeuvres.php");
	}
	else if($_GET['page'] == 'musique')
	{
	$_SESSION['page'] = "musique";
	include_once("affichage_oeuvres.php");
	}
	else if($_GET['page'] == 'profil_structure')
	{
	include_once("profil_structure.php");
	}
	else if($_GET['page'] == 'contact')
	{
	include_once("contact.php");
	}
	else if($_GET['page'] == 'recherche')
	{
	include_once("moteur_recherche.php");
	}
	else if($_GET['page'] == 'resultats')
	{
	include_once("resultats.php");
	}

}


?>
