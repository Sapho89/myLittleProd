<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link href="styleNew.css" rel="stylesheet" type="text/css" media="screen" />	
    </head>

<body>

<div id="EspaceSon">

<audio id="lecteur" controls="controls" autoplay loop>
  <source src="<?php echo $tab['url_son'];?>" type="audio/mp3" />
  Votre navigateur n'est pas compatible
</audio>

<br/>

Lecture en cours :  <?php echo $tab['titre']; ?>
</div>

</body>


</html>