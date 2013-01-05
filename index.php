<?php 
session_start(); 

?>

<!DOCTYPE html>
<html>
    <head>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js?ver=3.3.1'></script>
<script type="text/javascript" src="jquery.color.js"></script>
<script type='text/javascript' src='mesFonctions.js'></script>
<script type="text/javascript" src="formUser.js"></script>
<script type="text/javascript" src="formArt.js"></script> 
<title>My Little Prod</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lt IE 9]> 
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]--> <!-- Pour que IE comprenne balises HTML-->

<!--[if lte IE 7]>
<link rel="stylesheet" href="style_ie.css" />
<![endif]-->	
		
    </head>

<body onLoad="document.forms['connexionArt'].elements['pseudo'].focus()">
<?php
include_once("connexion.php");
include("mesfonctions.php");
include("fonction.php");

require_once("menu.php");

?>
		
<div class="main-content">

<?php

if ($_GET['page'] != '') {

  if( ($_GET['id_artiste'] == "") && ($_GET['id_oeuvre'] == "")) {	

			include_once("contenu_principal.php");
			
			}else  {
			
			include_once("description.php");
		    }
?>		
								

		
<?php }else { ?>		
	
	<div class="contenu_droite">
						
							<div class="affiche">
								&Ecirc;tes-vous dessinateur, chanteur, peintre ou encore &eacute;crivain ? 
								MyLittleProd organise un concours &agrave; la fois original et unique.
								Nous recherchons des personnes talentueuses. Pour participer, il vous suffit de cr&eacute;er un compte en tant qu'artiste. 
							</div>
						
								<div class="top-artiste">
									<h2>Profils les plus participatifs</h2>
									<?php include_once("top_artiste.php"); ?>
								</div>	
						
	</div>
					
					
					<div class='connexionArt'>
							<?php include_once("connexionArt.php"); ?>
					</div>


						<div class="contenu_central">
						
						</div>






	
<?php } ?>			
</div>			
		
</body>

</html>


