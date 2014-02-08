<?php

// BODYROCK Content /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// Bodyrock /////////////////////////////////////////////
// Affiche des modèles exemples d'éléments composés comme des articles, des listes d'articles, des widgets, etc...
// http://getbootstrap.com/css/
function br_contentBodyrock( $args = false ) {
	$args_defaults = array('nbofthiselement'=>1, 'code'=>false, 'element'=>'article_single_full', 'thumbnail'=>0);
	foreach ( $args_defaults as $P=>$val ) {
		if ( !isset( $args[$P] ) || $args[$P] == false ) {
			$args[$P] = $args_defaults[$P];
		}
	}
	
	// article_single_full
	$Bodyrock['article_single_full'] 	 = a("article.article");
	$Bodyrock['article_single_full'] 	.= a("header.art-header");
	$Bodyrock['article_single_full'] 	.= a("h1").br_getIcon()." Le titre de l'article, vous l'aurez compris".z("h1");
	$Bodyrock['article_single_full'] 	.= z("/header");
	$Bodyrock['article_single_full'] 	.= a("section.art-content");
	$Bodyrock['article_single_full'] 	.= a("p.lead")."Voici un <strong>article.article</strong>. Ici c'est l'intro, grâce à la classe .lead sur un paragraphe.".z("/p");
	$Bodyrock['article_single_full'] 	.= z("/section");
	$Bodyrock['article_single_full'] 	.= a("hr.clearfix");
	$Bodyrock['article_single_full'] 	.= a("section.art-vignette");
	$Bodyrock['article_single_full'] 	.= a("p").img($args['thumbnail']).z("/p");
	$Bodyrock['article_single_full'] 	.= z("/section");
	$Bodyrock['article_single_full'] 	.= a("section.art-content");
	$Bodyrock['article_single_full'] 	.= a("p")."Il est composé d'un <strong>header.art-header</strong> et d'une <strong>section.art-content</strong>. Dans cet article je peux mettre <a href='#'>des liens</a> s'il me plaît. Je peux écrire à volonté, vraiment, je ne suis pas limité. Et cela tombe bien, <em>j'aime écrire ici et là</em>.".z("/p");
	$Bodyrock['article_single_full'] 	.= a("p")."Un deuxième paragraphe pour la forme mais surtour pour tester la distance entre les paragraphes. C'est vraiment très important de vérifier à quoi cela va ressembler.".z("/p");
	$Bodyrock['article_single_full'] 	.= z("/section");
	$Bodyrock['article_single_full'] 	.= a("hr");
	$Bodyrock['article_single_full'] 	.= a("footer.art-footer");
	$Bodyrock['article_single_full'] 	.= "<p>A t-on évoqué le <strong>footer.art-footer</strong> ? Car il existe.".z("p");
	$Bodyrock['article_single_full'] 	.= z("/footer");
	$Bodyrock['article_single_full'] 	.= z("/article");
	
	// carousel
	$Bodyrock['carousel'] = '
	<div id="carousel-example-generic" class="carousel slide">
	<!-- Indicators -->
	<ol class="carousel-indicators">
	<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
	<li data-target="#carousel-example-generic" data-slide-to="1"></li>
	<li data-target="#carousel-example-generic" data-slide-to="2"></li>
	</ol>
	
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
	<div class="item active">
	'.img('medium').'
	<div class="carousel-caption">
	Titre de l\'image 1
	</div>
	</div>
	<div class="item">
	'.img('medium').'
	<div class="carousel-caption">
	Titre de l\'image 2
	</div>
	</div>
	<div class="item">
	'.img('medium').'
	<div class="carousel-caption">
	Titre de l\'image 3
	</div>
	</div>
	</div>
	
	<!-- Controls -->
	<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
	<span class="icon-prev"></span>
	</a>
	<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
	<span class="icon-next"></span>
	</a>
	</div>
	';
	
	$Bodyrock['dropdowns'] = '
		<div class="dropdown">
			<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
				Dropdown
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				<li role="presentation" class="dropdown-header">Dropdown header</li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
				<li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
			</ul>
		</div>

	';
	
	$Bodyrock['btn-dropdowns'] = '
		<div class="btn-group">
		  <button type="button" class="btn btn-danger">Action</button>
		  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
			<li><a href="#">Action</a></li>
			<li><a href="#">Another action</a></li>
			<li><a href="#">Something else here</a></li>
			<li class="divider"></li>
			<li><a href="#">Separated link</a></li>
		  </ul>
		</div>

	';
	
	$Bodyrock['btn-group'] = '
		<div class="btn-group">
			<button type="button" class="btn btn-default">Left</button>
			<button type="button" class="btn btn-default">Middle</button>
			<button type="button" class="btn btn-default">Right</button>
		</div>
	';
	
	$Bodyrock['btn-toolbar'] = '
		<div class="btn-group">
		<button type="button" class="btn btn-default">1</button>
		<button type="button" class="btn btn-default">2</button>
		
		<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		Dropdown
		<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
		<li><a href="#">Dropdown link</a></li>
		<li><a href="#">Dropdown link</a></li>
		</ul>
		</div>
		</div>
	';
		
	$Bodyrock['btn-nesting'] = '
		<div class="btn-group">
		  <button type="button" class="btn btn-default">1</button>
		  <button type="button" class="btn btn-default">2</button>
		
		  <div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			  Dropdown
			  <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			  <li><a href="#">Dropdown link</a></li>
			  <li><a href="#">Dropdown link</a></li>
			</ul>
		  </div>
		</div>
	';
	
	// RESULT
	$result = '';
	for($i=1;$i<=$args['nbofthiselement'];$i++) {
		$result .= 	$Bodyrock[$args['element']];
	}
	
	if ($args['code'] == true) {
		$makeitcode = str_replace('<','&lt;',$Bodyrock[$args['element']]);
		$makeitcode = str_replace('">','"&gt;<br>',$makeitcode);
		
		$result = $result.'<pre class="prettyprint"><small>'.$makeitcode.'</small></pre>';
	}
	
	return $result;
}

// OUVERTURE DE BALISE ///////////////////////////////////////////////
// Création de la balise ouverte $balise de la forme article.article.
// Exemples :
// $balise='div' return <div>
// $balise='div.column' return <div class="column">
// $balise='article.article' return <article class="article">
// $balise='div.class1.class2' return <div class="class1 class2">
// $balise='article.article', $id="#post-363" return <article class="article" id="post-363">
function a($balise, $id=false) {
	// id
	if($id!=false) {
		$id = str_replace('#','',$id);
		$id = ' id="'.$id.'"';
	}
	
	// class
	$class = false;
	if(strpos($balise,'.')>0) {
		$class = '';
		$B = explode('.',$balise);
		$balise = $B[0];
		$i=0;
		foreach($B as $res) { // Permet la gestion de plusieurs classes
			if($i==0) $balise = $B[$i];
			else $class .= $B[$i].' ';
			$i++;
		}
	}
	
	return "\n<".$balise.($class!=false ? " class='".$class."'" : false).$id.">\n";
}
// OUVERTURE DE BALISE ///////////////////////////////////////////////
// Ferme une balise
// Exemples :
// $balise='article' return </article>
// $balise='/article' return </article> :: Note on peut ajouter un slash / avant la balise pour une question de lisibilité mais il n'est pas obligatoire
function z($balise) {
	return "\n</".str_replace('/','',$balise).">\n";
}



?>

