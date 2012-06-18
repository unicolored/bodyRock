<?php

/**
*
* Parse les fichiers LESS en CSS à la volée.
*
*/

header('Content-Type: text/css');

error_reporting(0);

/* Si le fichier existe pas, on va pas plus loin */

if (!file_exists(dirname(__FILE__).'/'.$_GET['route']) || !preg_match('/\.(less|css)$/i',$_GET['route'])) die;

/* On va voir s'il y a du cache, déjà */

$cache_file = dirname(__FILE__) . '/data/cache/'.md5($_GET['route']);

/* On regarde s'il y a des fichiers importés dans le CSS (ne supporte qu'un niveau) */

$orig_less = file_get_contents(dirname(__FILE__).'/'.$_GET['route']);
preg_match_all('/@import \'(.+)\';/',$orig_less,$r);

$last_date = (int)filemtime(dirname(__FILE__).'/'.$_GET['route']);

foreach ($r[1] as $file) {

$mtime = (int)@filemtime(dirname(__FILE__).'/'.dirname($_GET['route']).'/'.$file.'.less');

if ($mtime > $last_date) {

$last_date = $mtime;

}

}

/* S'il n'y en a pas ou qu'il est trop vieux : Génération et sauvegarde du LESS */

if (!file_exists($cache_file) || (int)filemtime($cache_file) < $last_date) {

include('lessc.inc.php');

$lc = new lessc(dirname(__FILE__).'/'.$_GET['route']);

$css = $lc->parse();

@unlink($cache_file);
file_put_contents($cache_file,$css);

echo $css;

} else {

echo file_get_contents($cache_file);

}

?>