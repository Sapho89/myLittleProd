
<script type="text/javascript">
function show(){

	document.getElementById('niveau2').style.display = 'block';

}
</script>


				<div class="menu" >

	<nav>
				<ul>
				
				<!--<li><a href="index.php"><img src="logo.jpg" id="logo"/></a></li>-->
				<li class="niveau1"><a href="index.php" id="accueil">Accueil</a></li>
				<li class="niveau1"><a href="index.php?page=video">Vid&eacute;o</a></li>
				<li class="niveau1"><a href="index.php?page=musique">Musique</a></li>
				<li class="niveau1"><a href="index.php?page=image">Image</a></li>
				<li class="niveau1"><a href="index.php?page=litterature">Litt&eacute;rature</a></li>
				<li >				
				<a href='#' onClick="show();" >Moteur de recherche</a>

						<?php include_once("moteur_recherche.php"); ?>
	
				</li>
					
				
				<?php if( isset($_SESSION['type']) && !empty($_SESSION['type'])) { ?>
				<li class=""><a href="index.php?page=profil_structure">Mon profil</a></li> 
				<?php }
				
				?>
				<div id="deconnexion"><a href="deconnexion.php"><img src="logout.png"/>&nbsp;Se d&eacute;connecter</a></div>
				</ul>
	</nav>
	
				</div>
