<?php
/* ** ** ** ** ICONES ** ** ** ** */ // 07/11/14
/* tpl/dummy/icones.php
 * Appeler ce fichier dans vos templates grâce :
 * - à la fonction Wordpress :      get_template_part('tpl/dummy/icones') 
 * - au raccourci BodyRock          br_dummy('icones') 
 * 
/**********************************/

// // Liste des icones dont les appellations sont similaires entres Glyphicons, Font-Awesome, Elusive.
foreach(br_getAvailableIcones() as $icon) { ?>
      
      <div class="thumbnail col-xs-2">
            <h1><?php br_Icon($icon); ?></h1>
            <div class="caption">
                  <h1><?php echo $icon ?></h1>
            </div>
      </div>
      
<?php
}
