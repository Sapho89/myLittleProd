<?php 
session_start(); 
?>

							<?php
                                              
                                                $requete = "SELECT o.*,a.*,g1.id_genre, g1.genre as genre1, g1.type,g2.id_genre, g2.genre as genre2, g2.type FROM oeuvre as O, genre as g1, genre as g2, artiste as A WHERE g1.type='".$_SESSION['page']."' AND O.id_genre1 = g1.id_genre AND O.id_genre2 = g2.id_genre AND O.id_artiste = A.id_artiste";
                            
                                                    if($res=mysql_query($requete))
												{ 
                                                        $i=0;
                                                        WHILE($tab=mysql_fetch_assoc($res))
														{                              
														?>
                                                                   <table>
																   
																   <tr>
																   
																	   <td>
																	       <a href="index.php?page=<?php echo $tab['type']; ?>&id_artiste=<?php echo $tab['id_artiste']; ?>&id_oeuvre=<?php echo $tab['id_oeuvre'];?>" target="_self">
																	  
																	       <img src="<?php echo $tab['url']; ?>" class="miniature" title="<?php echo $tab['titre']; ?>" alt="<?php echo $tab['titre']; ?>"/></a>
																	 
																	   </td>
																	   
																   <td>
																   <h3><?php echo htmlentities($tab['titre']); ?></h3>
																   R&eacute;alis&eacute par <?php echo htmlentities($tab['prenom'])."&nbsp;".htmlentities($tab['nom']); ?>
																   <br/>
																   Genre : <?php if($tab['genre1'] == $tab['genre2']) { echo $tab['genre1']; } else { echo $tab['genre1'].",&nbsp;".$tab['genre2']; } ?>
																   </td>
																   
																   </tr>
																   
																   </table>
																   
                                                        <?php   $i++; 
                                                        }
                                                                
                                                }	else die("erreur sur la recuperation des donnees :" .mysql_error());
                                                        ?>
