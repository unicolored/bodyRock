<?php

// BOOTSTRAP Content /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// CSS /////////////////////////////////////////////
// Affiche les éléments Html de base pour vérifier leur mise en forme.
// http://getbootstrap.com/css/
function br_content_bootstrapCSS() {
	
	$H = '';
	$HP;
	
	for($i=1;$i<=6;$i++) {
		$H .= '<h'.$i.'>Bodyrock Titre <small>numero n°'.$i.'</small></h'.$i.'>';
	}
	
	for($i=1;$i<=6;$i++) {
		$HP .= '<h'.$i.'>Bodyrock Titre <small>numero n°'.$i.'</small></h'.$i.'>';
		$HP .= '<p>All HTML headings, through &lt;h1> to &lt;h6&gt;, are available. .h1 through .h6 classes are also available, for when you want to <span class="h'.$i.'">match the font styling of a heading (here, h'.$i.')</span> but still want your text to be displayed inline. Create lighter, secondary text in any heading with a generic &lt;small&gt; tag or the .small class.</p>';
	}
	
	$P = '
		<p>Bootstrap\'s global default font-size is 14px, with a line-height of 1.428. This is applied to the &lt;body&gt; and all paragraphs. In addition, &lt;p&gt; (paragraphs) receive a bottom margin of half their computed line-height (10px by default).</p>
		
		<p>The typographic scale is based on two LESS variables in variables.less: @font-size-base and @line-height-base. The first is the base font-size used throughout and the second is the base line-height. We use those variables and some simple math to create the margins, paddings, and line-heights of all our type and more. Customize them and Bootstrap adapts.</p>
		
		<p class="lead">Make a paragraph stand out by adding .lead. Here at the different emphasis :</p>
		
		<p>Here he comes Here comes <abbr title="definition de l\'abréviation">abréviation</abbr> et un <abbr title="HyperText Markup Language" class="initialism">initialism</abbr>. <small>This line of text is meant to be treated as fine print.</small> He\'s a demon on wheels. Didn\'t need no welfare <strong>rendered as bold text</strong> states. Everybody pulled his weight. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum. What might be right for you may not be right for some.</p>
		
		<p class="text-left">Left aligned text.</p>
		<p class="text-center">Center aligned text.</p>
		<p class="text-right">Right aligned text.</p>
		
		<h1 class="text-muted">Text muted by titre h1</h1>
		<p class="text-muted">Text muted Everybody pulled his weight. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum.</p>
		<h2 class="text-primary">Text primary by titre h2</h2>
		<p class="text-primary">Text primary Everybody pulled his weight. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum.</p>
		<h3 class="text-success">Text success by titre h3</h3>
		<p class="text-success">Text success Everybody pulled his weight. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum.</p>
		<h4 class="text-info">Text info by titre h4</h4>
		<p class="text-info">Text info Everybody pulled his weight. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum.</p>
		<h5 class="text-warning">Text warning by titre h5</h5>
		<p class="text-warning">Text warning Everybody pulled his weight. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum.</p>
		<h6 class="text-danger">Text danger by titre h6</h6>
		<p class="text-danger">Text dangerEverybody pulled his. Gee our old Lasalle ran great. Those were the days. A man is born he\'s a man of means <em>rendered as italicized text</em>. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. We\'re gonna make our dreams come true. Movin\' on up to the east side. We finally got a piece of the pie. So this is the tale of our castaways they\'re here for a long long time. They\'ll have to make the best of things its an uphill climb? Now the world don\'t move to the beat of just one drum.</p>

	';
	
	$ADDRESS = '
		<address>
		  <strong>Twitter, Inc.</strong><br>
		  795 Folsom Ave, Suite 600<br>
		  San Francisco, CA 94107<br>
		  <abbr title="Phone">P:</abbr> (123) 456-7890
		</address>
		
		<address>
		  <strong>Full Name</strong><br>
		  <a href="mailto:#">first.last@example.com</a>
		</address>
	
	';
	
	$BLOCKQUOTE = '
		<blockquote>
		  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
		</blockquote>
	<blockquote>
	  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
	  <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
	</blockquote>

	';
	
	$LIST_UNORDERED = '
		<h1>Les différentes listes</h1>
		<h3>List unordered ul</h3>
		<ul>
		<li>Lorem ipsum dolor sit amet</li>
		<li>Consectetur adipiscing elit</li>
		<li>Integer molestie lorem at massa</li>
		<li>Facilisis in pretium nisl aliquet</li>
		<li>Nulla volutpat aliquam velit
		<ul>
		<li>Phasellus iaculis neque</li>
		<li>Purus sodales ultricies</li>
		<li>Vestibulum laoreet porttitor sem</li>
		</ul>
		</li>
		<li>Ac tristique libero volutpat at</li>
		<li>Faucibus porta lacus fringilla vel</li>
		<li>Aenean sit amet erat nunc</li>
		<li>Eget porttitor lorem</li>
		</ul>
	
	';
	
	$LIST_ORDERED = '
		<h3>List ordered ol</h3>
		<ol>
		<li>Lorem ipsum dolor sit amet</li>
		<li>Consectetur adipiscing elit</li>
		<li>Integer molestie lorem at massa</li>
		<li>Facilisis in pretium nisl aliquet</li>
		<li>Nulla volutpat aliquam velit
		<ol>
		<li>Phasellus iaculis neque</li>
		<li>Purus sodales ultricies</li>
		<li>Vestibulum laoreet porttitor sem</li>
		</ol>
		</li>
		<li>Ac tristique libero volutpat at</li>
		<li>Faucibus porta lacus fringilla vel</li>
		<li>Aenean sit amet erat nunc</li>
		<li>Eget porttitor lorem</li>
		</ol>
	
	';
	
	$LIST_UNSTYLE = '
		<h3>List unstyled .list-unstyled</h3>
		<ul class="list-unstyled">
		<li>Lorem ipsum dolor sit amet</li>
		<li>Consectetur adipiscing elit</li>
		<li>Integer molestie lorem at massa</li>
		<li>Facilisis in pretium nisl aliquet</li>
		<li>Nulla volutpat aliquam velit
		<ul>
		<li>Phasellus iaculis neque</li>
		<li>Purus sodales ultricies</li>
		<li>Vestibulum laoreet porttitor sem</li>
		</ul>
		</li>
		<li>Ac tristique libero volutpat at</li>
		<li>Faucibus porta lacus fringilla vel</li>
		<li>Aenean sit amet erat nunc</li>
		<li>Eget porttitor lorem</li>
		</ul>
	
	';
	
	$LIST_INLINE = '
		<h3>List inline .list-inline</h3>
		<ul class="list-inline">
		<li>Lorem ipsum dolor sit amet</li>
		<li>Consectetur adipiscing elit</li>
		<li>Integer molestie lorem at massa</li>
		<li>Facilisis in pretium nisl aliquet</li>
		<li>Ac tristique libero volutpat at</li>
		<li>Faucibus porta lacus fringilla vel</li>
		<li>Aenean sit amet erat nunc</li>
		<li>Eget porttitor lorem</li>
		</ul>
	
	';
	
	$DESCRIPTION = '
		<h3>Descriptions</h3>
		<dl>
		  <dt>Titre de la description</dt>
		  <dd>Information sur la description.</dd>
		</dl>
		
		<h4>Horizontal Description</h4>
		<dl class="dl-horizontal">
		  <dt>Titre de la description</dt>
		  <dd>Horizontal description lists will truncate terms that are too long to fit in the left column with text-overflow. In narrower viewports, they will change to the default stacked layout.</dd>
		</dl>
	
	';
	
	$CODE_BASIC = '
		<p>For example, <code>&lt;section&gt;</code> should be wrapped as inline.</p>
		
		<pre>&lt;p&gt;Sample text here...&lt;/p&gt;</pre>
		
		<pre class="pre-scrollable">Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it. Then along come two they got nothin\' but their jeans? They call him Flipper Flipper faster than lightning. No one you see is smarter than he., " These days are all Happy and Free. These days are all share them with me oh baby." Were gonna do it. Give us any chance well take it. Give us any rule we\'ll break it.</pre>

	';
	
	$TABLE = '
	
		<table>
			<thead>
				<tr>
					<th>unclassed</th>
					<th>Head</th>
					<th>Head</th>
					<th>Head</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Class .table</th>
					<th>.table-striped</th>
					<th class="warning">.table-hover</th>
					<th>Head</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
				<tr class="success">
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-bordered table-condensed">
			<thead>
				<tr class="danger">
					<th>Class .table</th>
					<th>.table-bordered</th>
					<th>.table-condensed</th>
					<th>Head</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td class="active">Active</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
			</tbody>
		</table>
		
		<div class="table-responsive">
		<table class="table table-bordered table-condensed">
			<thead>
				<tr class="danger">
					<th>Class .table wrapped by .table-responsive</th>
					<th>.table-bordered</th>
					<th>.table-condensed</th>
					<th>Head</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td class="active">Active</td>
					<td>Body</td>
				</tr>
				<tr>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
					<td>Body</td>
				</tr>
			</tbody>
		</table>
		</div>
	
	';
	
	$FORMS = '
		<form role="form">
		  <div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
		  </div>
		  <div class="form-group">
			<label for="exampleInputFile">File input</label>
			<input type="file" id="exampleInputFile">
			<p class="help-block">Example block-level help text here.</p>
		  </div>
		  <div class="checkbox">
			<label>
			  <input type="checkbox"> Check me out
			</label>
		  </div>
		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
		
		<form class="form-inline" role="form">
		  <div class="form-group">
			<label class="sr-only" for="exampleInputEmail2">Email address</label>
			<input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
		  </div>
		  <div class="form-group">
			<label class="sr-only" for="exampleInputPassword2">Password</label>
			<input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
		  </div>
		  <div class="checkbox">
			<label>
			  <input type="checkbox"> Remember me
			</label>
		  </div>
		  <button type="submit" class="btn btn-default">Sign in</button>
		</form>
		
		<p>Most common form control, text-based input fields. Includes support for all HTML5 types: text, password, datetime, datetime-local, date, month, time, week, number, email, url, search, tel, and color</p>
		
		<form class="form-horizontal" role="form">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="checkbox">
				<label>
				  <input type="checkbox"> Remember me
				</label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-default">Sign in</button>
			</div>
		  </div>
		</form>


	';
	
	$BUTTONS = '	
		<!-- Standard button -->
		<button type="button" class="btn btn-default">Default</button>
		
		<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
		<button type="button" class="btn btn-primary">Primary</button>
		
		<!-- Indicates a successful or positive action -->
		<button type="button" class="btn btn-success">Success</button>
		
		<!-- Contextual button for informational alert messages -->
		<button type="button" class="btn btn-info">Info</button>
		
		<!-- Indicates caution should be taken with this action -->
		<button type="button" class="btn btn-warning">Warning</button>
		
		<!-- Indicates a dangerous or potentially negative action -->
		<button type="button" class="btn btn-danger">Danger</button>
		
		<!-- Deemphasize a button by making it look like a link while maintaining button behavior -->
		<button type="button" class="btn btn-link">Link</button>

	';
	
	$IMAGES = '
		<img src="http://placehold.it/1024x480" alt="..." class="img-rounded img-responsive">
		<img src="http://placehold.it/1024x480" alt="..." class="img-circle img-responsive">
		<img src="http://placehold.it/1024x480" alt="..." class="img-thumbnail img-responsive">	
		<div class="thumbnail">
		<img src="http://placehold.it/1024x480" alt="..." class="img-circle">	
		</div>

	';
	
	/* A continuer avec tous les éléments de la page bootstrap à partir de http://getbootstrap.com/css/#images */
	/* Il reste : Images */
	
	$CSS = $H.$HP.$P.$ADDRESS.$BLOCKQUOTE.$LIST_UNORDERED.$LIST_ORDERED.$LIST_UNSTYLE.$LIST_INLINE.$DESCRIPTION.$CODE_BASIC.$TABLE.$FORMS.$BUTTONS.$IMAGES;
	
	return $CSS;
}

/* Continuer avec les components */

?>

