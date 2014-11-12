<?php
header("Content-type: image/png");
// Récupération des valeurs
$height = 297;
$width = 210;
$text = (!empty($_GET['content']))?$_GET['content']:'Vide';

// Génération de l'image
$image = imagecreatetruecolor($width, $height);

// Conversion code couleur HTML vers RGB
$color = "CCCCCC";
$rouge = hexdec(substr($color,0,2));
$vert = hexdec(substr($color,2,2));
$bleu = hexdec(substr($color,4,2));
$color = imagecolorallocate($image, $rouge, $vert, $bleu);

// Modifier la variable d'environnement pour GD (police ttf dans le rep du script)
putenv('GDFONTPATH=' . realpath('.'));
//echo realpath('.');

$angle = 0;
$font = $_GET['font'].'.ttf';

$LINES = explode( '<br />',$text );

$i = 1;
foreach ($LINES as $LINE) {
    $size = 20;
    $le_texte = trim($LINE);

    //Calcule la longueur et la largeur du texte
    $bbox = imagettfbbox ($size, $angle, $font, $le_texte);
    $textWidth = $bbox[2] - $bbox[0]+1;
    $textHeight = $bbox[3] - $bbox[7]+1;
    
    if($textWidth>($width-($width/9))) {
        $rapport = ($width/1.2)/$textWidth;
        $size = $size*$rapport;
        //Calcule la longueur et la largeur du texte
        $bbox = imagettfbbox ($size, $angle, $font, $le_texte);
        $textWidth = $bbox[2] - $bbox[0]+1;
        $textHeight = $bbox[3] - $bbox[7]+1;
    }
    if($textWidth<($width)
        && strpos($le_texte,'-j-')!=false) {
        $le_texte = str_replace('-j-','',$le_texte);
        $bbox = imagettfbbox ($size, $angle, $font, $le_texte);
        $textWidth = $bbox[2] - $bbox[0]+1;
        $textHeight = $bbox[3] - $bbox[7]+1;
        //Calcule la longueur et la largeur du texte
        $rapport = ($width/1.2)/$textWidth;
        $size = $size*$rapport;
        
        $bbox = imagettfbbox ($size, $angle, $font, $le_texte);
        $textWidth = $bbox[2] - $bbox[0]+1;
        $textHeight = $bbox[3] - $bbox[7]+1;
        
    }
    
    $x = (($width-$textWidth)/2);
    $y = $textHeight+50*$i;
    imagettftext ($image, $size, $angle, $x, $y, $color, $font, $le_texte.strpos($le_texte,'-j-'));
    
    $i++;
}

if(isset($_GET['auteur']) && $_GET['auteur'] != 'false') {
    $size = 6;
    $le_texte = '- '.$_GET['auteur'].' -';
    $font = 'DoppioOne.ttf';
    //Calcule la longueur et la largeur du texte
    $bbox = imagettfbbox ($size, $angle, $font, $le_texte);
    $textWidth = $bbox[2] - $bbox[0]+1;
    $textHeight = $bbox[3] - $bbox[7]+1;
    
    $x = (($width-$textWidth)/2);
    $y = $height-50;
    $color = imagecolorallocate($image, 128, 128, 128);
    imagettftext ($image, $size, $angle, $x, $y, $color, $font, $le_texte);
}

//renvoie une image sous format png
imagepng($image);

//détruit l'image pour libérer l mémoire
imagedestroy($image);
?>