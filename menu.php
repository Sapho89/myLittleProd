				<div class="menu" >

	<nav>
				<ul>
				
				<!--<li><a href="index.php"><img src="logo.jpg" id="logo"/></a></li>-->
				<li class="niveau1"><a href="index.php" id="accueil">Accueil</a></li>
				<li class="niveau1"><a href="index.php?page=video">Vid&eacute;o</a></li>
				<li class="niveau1"><a href="index.php?page=musique">Musique</a></li>
				<li class="niveau1"><a href="index.php?page=image">Image</a></li>
				<li class="niveau1"><a href="index.php?page=litterature">Litt&eacute;rature</a></li>
				<li>				
				<a href="index.php?page=recherche">Moteur de recherche</a>

						<?php include_once("moteur_recherche.php"); ?>
	
				</li>
					
				
				<?php if($_SESSION['type'] != '') { ?>
				<li class=""><a href="index.php?page=profil_structure">Mon profil</a></li> 
				<?php }
				
				//echo $_SESSION['type'];
				if($_SESSION['type'] != "")
				{
				?>
				<div id="deconnexion"><a href="deconnexion.php"><img src="logout.png"/>&nbsp;Se d&eacute;connecter</a></div>
				<?php
				}
				?>
				</ul>
	</nav>
	
				</div>
