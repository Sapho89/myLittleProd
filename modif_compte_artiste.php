<?php
		//ARTISTE
			//GESTION DU COMPTE 
			if( isset($_GET['gestion'])) {  
				
				//TRAITEMENT DES DONNEES MODIFIES				
				if( isset($_POST['nom']) && isset($_POST['prenom']))
					{
					$nom = mysql_real_escape_string ($_POST['nom']);
					$prenom = mysql_real_escape_string ($_POST['prenom']);
					$pseudo = mysql_real_escape_string ($_POST['pseudo']);
					$description = htmlspecialchars(mysql_real_escape_string($_POST['description']));
					$mail = $_POST['mail'];
					
					//Si $_POST['avatar_local'] avait une valeur,
					//$avatar = $_POST['avatar_local'];
					
				$req = "SELECT * FROM ARTISTE WHERE id_artiste = ".$_SESSION['id_artiste'];
				$res = mysql_query($req);
				if($res) $ligne = mysql_fetch_assoc($res);
				
				$url = upload_image($FILES['avatar_local']['name'],250,250,1000 * 1024); //Dimension/Format/Poids  modifiables
				
				$addArt = "UPDATE `artiste` SET
				`nom`= '$nom',`prenom`='$prenom',`pseudo`='$pseudo',`mail`= '$mail',
				`description`='$description'";	
				if( $url != NULL ) $addArt .= ",`avatar`= '$url'";
				$addArt .= "WHERE id_artiste = ".$_SESSION['id_artiste'];
				//echo $addArt;
				mysql_query($addArt);
				}
				
				if($_GET['gestion'] == 'modification'){  //Modification 
				
				 //Formulaire rempli avec donnees de la base
				$req = "SELECT * FROM `artiste` WHERE `id_artiste` = ".$_SESSION['id_artiste'];
				$res = mysql_query($req);
				$ligne = mysql_fetch_assoc($res); 
				?>

				
				<!--Affichage du formulaire Artiste -->
				<form name='formArt' id='inscriptionArt' method='POST' action='index.php?page=profil_structure&gestion=modification' enctype='multipart/form-data' > <!-- onSubmit='checkForm()'-->
				 
				<div class='champs' align='middle'>
				<h3>Modification de votre profil</h3>
					<div><label for='nom'>Nom :</label><input type='text' name='nom' id='nom' onKeyUp="check('nom')" value='<?php echo $ligne['nom'];?>'/>&nbsp;
					<span id='verifNom'></span></div><br/>
					
					<div><label for='prenom'>Pr&eacute;nom :</label><input type='text' name='prenom' id='prenom' onMouseOut="check('prenom')" value='<?php echo $ligne['prenom']; ?>'/>&nbsp;
						<span id='verifPrenom'></span>
					</div><br/>
					
					<div><label for='pseudo'>Nickname :</label><input type='text' name='pseudo' id='pseudo' onMouseOut="check('pseudo')" value='<?php echo $ligne['pseudo']; ?>'/>&nbsp;
					<span id='verifPseudo'></span></div><br/>
				<div><label for='description'>Pr&eacute;sentez-vous (vos hobbies, vos ambitions, etc...) :</label><br /><br />
				  <textarea name='description' rows='8' cols='75' maxlength='600' id='description' onMouseOut="check('description')"><?php echo $ligne['description']; ?></textarea>
				&nbsp;<span id='verifDescription'></span>
				</div>
				
				<div><label for='mail'>Adresse mail :</label> <input type='text' name='mail' id='mail' onMouseOut='check('mail')' value='<?php echo $ligne['mail'];?>'/>&nbsp;
				<span id='verifMail'></span></div>			
				
				<h4>Avatar</h4> 
					<img id='avatar_photo' src='<?php echo $ligne['avatar']; ?>' width='100px' height='100px' /><br /> 
					<br /><label for='cover'>Telecharger un fichier</label>&nbsp;&nbsp;
					<input type='hidden' name='MAX_FILE_SIZE' value='10240000' /> <!-- Max données transporté par le formulaire -->
					<input type='file' onKeyUp="avatar_mini('')" id='avatar_local' name='avatar_local' />
					<br /><span  style='color:red;font-weight:bold;'>*</span>
					<span id='verifUrl'> L'url de votre photo de couverture doit finir  en .jpg, .png ou .gif</span>
					<br />
				
				<input type='reset' name='Annuler' value='Annuler' />
				<input type='submit' name='Envoyer' value='Envoyer' /> 
				</div>
				</form> <?php
				}
				else{ //Suppression du profil Artiste
				$req_commentaires = "DELETE  FROM `commentaire` WHERE `id_artiste` = ".$_SESSION['id_artiste']." OR `id_membre` = ".$_SESSION['id_artiste'];
				
				$req_oeuvres1 = "SELECT url,extrait_url FROM `oeuvre` WHERE `id_artiste` = ".$_SESSION['id_artiste'];
				$req_oeuvres2 = "DELETE FROM `oeuvre` WHERE `id_artiste` = ".$_SESSION['id_artiste'];
				
				$req_fiche1 = "SELECT avatar FROM `artiste` WHERE `id_artiste` = ".$_SESSION['id_artiste'];
				$req_fiche2 = "DELETE FROM `artiste` WHERE `id_artiste` = ".$_SESSION['id_artiste'];
				
				$res_commentaires = mysql_query($req_commentaires);
				$res_oeuvres1 = mysql_query($req_oeuvres1);
				$res_fiche1 = mysql_query($req_fiche1);
					
					while ($ligne_oeuvres = mysql_fetch_assoc($res_oeuvres1)){
						if( preg_match('#^texte\/#',$ligne_oeuvres1['url']) ) unlink("".$ligne_oeuvres1['url'].""); 
					}
					mysql_query($req_oeuvres2);
					
					echo $req_commentaires;
					echo "<br />";
					
					echo $req_oeuvres1;
					echo $req_oeuvres2;
					echo "<br />";
					
					echo $req_fiche1;
					echo $req_fiche2;
					echo "<br />"; 
					
			$ligne_fiche1 = mysql_fetch_assoc($res_fiche1);
				if(preg_match('#^avatar\/#',$ligne_fiche1['avatar'])) unlink("".$ligne_fiche1['avatar']."");
			mysql_query($req_fiche2);
					
					header('location:index.php?page=index');
				} 
			} //FIN de Modification/Suppression du compte
			
			else{  //Affichage du compte Artiste
			$req_fiche = "SELECT `id_artiste`, `talent`, `nom`, `prenom`, `pseudo`, `mdp`, 
			`mail`, `date_naissance`, `avatar`, `date_updated`, `description` 
			FROM `artiste` 
			WHERE id_artiste = ".$_SESSION['id_artiste'];

			$res_fiche = mysql_query($req_fiche);
			$ligne_fiche = mysql_fetch_assoc($res_fiche);
			
			echo "<div id='fiche'>";
			echo"<div id='coco'style='border-bottom:7px black ridge;margin-bottom: 10px;'>
			<span id='modif_fiche' class='section_titre' align='left'>Votre Profil</span>
			</div>";
			echo "<img id='avatar' src='".$ligne_fiche['avatar']."' width='200' height='200'>";
			echo "<table border='none'>";
				echo "<tr>	
					  <td><b>Nom: </b></td> <td>".$ligne_fiche['nom']."</td>";
				echo "<td><b>Prenom: </b></td> <td>".$ligne_fiche['prenom']."</td>	
					 </tr>";
					 
				echo "<tr>	
					  <td><b>Nickname0: </b></td> <td>".$ligne_fiche['pseudo']."</td>";
				echo "<td><b>Mail: </b></td> <td>".$ligne_fiche['mail']."</td>	
					</tr>";
					
				echo "<tr>	
					  <td><b>Date De Naissance: </b></td> <td>".$ligne_fiche['date_naissance']."</td>";
				echo "<td><b>Talent: </b></td> <td>".$ligne_fiche['talent']."</td>	
					 </tr>";
				echo "<tr>	
					  <td><b>Date d'inscription: </b></td> <td>".$ligne_fiche['date_updated']."</td>	
					 </tr>";
				echo "<tr>	
					  <td colspan='4'><b>Description: </b><i>".$ligne_fiche['description']."</i></td>
					</tr>";
			echo "</table><br /><br />";
			echo "<span><a href='index.php?page=profil_structure&onglet=profil&gestion=modification'><img src='icones\cle_a_molette3.jpg' width='25px' height='25px'/>Modifier son profil</a>&nbsp;&nbsp;&nbsp;
			<a href='index.php?page=profil_structure&onglet=profil&gestion=supprimer'><img src='icones\poubelle.jpg' width='25px' height='25px'/>Supprimer son compte</a></span>";
			echo '</div>';
			
			echo "<div id='bloc_interaction'><div style='border-bottom:7px black ridge;margin-bottom: 10px;'>
			<div class='section_titre' align='center'>Vos Commentaires</div></div>";
			affichComOeuvreFromId($_SESSION["id_artiste"]);
			echo '</div>';
			} //Fin de affichage compte Artiste