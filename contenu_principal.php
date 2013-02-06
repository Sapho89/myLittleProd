<?php

$page = $_GET['page'];

/*
if(!empty($page))
{
	$tab = array("video","litterature","image","musique");
	
	//Pages thématiques
	if(in_array($page,$tab)){
		$_SESSION['page'] = $page;
		include_once("affichage_oeuvres.php");
	}
	else { 
		switch($page){
			case 'profil_structure' : 	include_once("profil_structure.php"); break;
			case 'contact' : 			include_once("contact.php"); break;
			//case 'recherche' : 			include_once("moteur_recherche.php"); break;
			case 'resultats' : 			include_once("resultats.php"); break;
			default: header('location: erreur 404.php');
		}
		  }
}
*/


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
	else if($_GET['page'] == 'inscriptionArt')
	{
	include_once("inscriptionArt.php");
	}
	else if($_GET['page'] == 'inscriptionUser')
	{
	include_once("inscriptionUser.php");
	}

}




?>
