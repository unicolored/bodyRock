<?php
global $urlfinale, $videoType, $videoCode;

	$custom = get_post_custom($post->ID);
	$Lieu = $custom["eventlieuId"][0];

echo a('article.article','#post-'.get_the_ID());

if( has_post_thumbnail() ) {
	echo '<section class="art-vignette">';
	the_post_thumbnail('large',array('class'=>'img-responsive'));
	echo '</section>';
}

echo a('header.art-header');
echo '<h1>'.strip_tags(get_the_title()).'</h1>';


	$categories = get_the_terms(get_the_ID(), 'event-type');
	if ( $categories != false ) {
		foreach($categories as $k=>$v) {
			echo '<span class="label label-default label-'.$v->slug.'">'.$v->name.'</span> ';
		}
	}
	
	
?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse">
			<?php echo ''.br_getIcon('map-marker').' '.get_the_title($Lieu).''; ?>
        </a>
      </h4>
    </div>
    <div id="collapse" class="panel-collapse collapse">
      <div class="panel-body">
		<section class="art-content">
			<?php
			the_content(false,1);
			?>
		</section>
      </div>
    </div>
  </div>
<?php
echo z('/header');
?>



	
	<hr class="clearfix">
<hr>	
	
<section class="art-partage">
<section class="hidden">
	<div class="col-f">
		<?php get_template_part('tpl/parts/article', 'share') ?>
	</div>

	<div class="col-f">
		<a class="addthis_button_facebook_like" fb:like:layout="standard"></a> 
		<br>
		<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		
		<p>Lien court :
		<?php
			$ch = curl_init('http://api.bitly.com/v3/shorten?login=unicolored&apiKey=R_8de9dc884a5f6e6ba8831909df65d03c&longUrl='.get_permalink());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			 
			$result = curl_exec($ch);
			$R = json_decode($result);
		?>
		<input type="text" value="<?php echo $R->data->url ?>" class="form-control">
		</p>
	</div>
	<hr class="clearfix">
</section>
</section>

<section class="text-center">
<?php
	$DateStart = $custom["eventstartDate"][0];
	$DateEnd = $custom["eventendDate"][0];
if($DateStart<date("Y-m-d")) echo '<div class="alert alert-danger">'.br_getIcon('chevron-right').' Cet évènement est <strong>terminé</strong>.</div>';
if($DateEnd<date("Y-m-d")) {
	echo '<h1>'.br_getIcon('calendar').' '.br_DateWord($DateStart).'</h1>';
}
if($DateEnd!=$DateStart && $DateEnd>date("Y-m-d")) {
	echo '<h1>Jusqu\'au '.strtolower(br_DateWord($DateEnd)).'</h1>';
	echo 'Depuis le '.br_DateFull($DateStart);
}
if ($custom["gratuitEvent"][0]==true) {
	echo '<h4>'.br_getIcon('gift').' '.$custom["gratuitEvent"][0].'</h4><br>';
}
if ($custom["tarifsEvent"][0]!=false) {
	echo '<h4>'.br_getIcon('barcode').' Tarifs</h4><br>';
	echo '<p>'.$custom["tarifsEvent"][0].'</p>';
}
if ($custom["horairesEvent"][0]!=false) {
	echo '<h4>'.br_getIcon('bell').' Horaires</h4><br>';
	echo '<p>'.$custom["horairesEvent"][0].'</p>';
}
if ($custom["telephoneEvent"][0]!=false) {
	echo '<a href="" class="btn btn-default btn-block" target="_blank">'.br_getIcon('phone').' '.$custom["telephoneEvent"][0].'</a>';
}
if ($custom["sitewebEvent"][0]!=false) {
	echo '<a href="" class="btn btn-default btn-block" target="_blank">'.br_getIcon('globe').' '.$custom["sitewebEvent"][0].'</a>';
}
?>
<hr class="clearfix">
</section>
<hr>


	<?php
	echo Get_artfooter(false);
	?>
	
<hr class="clearfix">


<div class="panel-group" id="accordion">
<?php
			if(the_content(false,1)) {
			?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			<?php br_Icon('list-alt') ?> Informations
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
		<section class="art-content">
			<?php
			the_content(false,1);
			?>
		</section>
      </div>
    </div>
  </div>
<?php
			}
			?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
			<?php br_Icon('comment') ?> Avis
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
		<section class="art-comments col-ff">
		<?php comments_template( '', true ); ?>
		</section>
      </div>
    </div>
  </div>
</div>

</article>

