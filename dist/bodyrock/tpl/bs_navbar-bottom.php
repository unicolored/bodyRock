<nav id="navbarbot" class="navbar navbar-default navbar-fixed-bottom" role="navigation">

  <div class="navbar-header">
    <a class="navbar-brand" href="<?php bloginfo('url'); ?>">
      <span><?php bloginfo('name') ?></span>
    </a>
    <p class="navbar-text"><small><span id="date_heure"></span></small></p>
  </div>

  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-right">
      <li><a title="Retour en haut de la page" href="#top"><span class="glyphicon glyphicon-chevron-up"></span></a>
      </li>
    </ul>
  </div>


  <script type="text/javascript">
  function date_heure(id) {
    date = new Date;
    annee = date.getFullYear();
    moi = date.getMonth();
    mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
    j = date.getDate();
    jour = date.getDay();
    jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
    h = date.getHours();
    if (h < 10) {
      h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10) {
      m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10) {
      s = "0" + s;
    }
    resultat = jours[jour] + ' ' + j + ' ' + mois[moi] + ' ' + annee + ' / ' + h + ':' + m + ':' + s;
    document.getElementById(id).innerHTML = resultat;
    setTimeout('date_heure("' + id + '");', '1000');
    return true;
  }

  window.onload = date_heure('date_heure');
  </script>

</nav>
