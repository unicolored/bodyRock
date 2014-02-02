<div id="tweet">
	<?php
	$twitter='rastared/twitter.json';
	$jsonData = json_decode(file_get_contents($twitter));
//						var_dump($jsonData);
//var_dump($instagram);
	$i=1;
	foreach ($jsonData as $key=>$value) {
		if($i<6 && $value->source!='<a href="http://instagram.com" rel="nofollow">Instagram</a>') {
			if(!strstr($value->text,'A la #une')) {
				?>
				
			
				
				<div class="t_<?php echo trim(strtolower(str_replace(' ','_',strip_tags($value->source)))) ?>">
					<h5><?php echo preg_replace('/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/','<a target="_blank" href="$0">'.$value->entities->urls[0]->display_url.'</a>',$value->text) ?></h5>
				</div>
			<?php
				$i++;
			}
		}
	}
	?>
	<hr class="clearfix" />
	<a target="_blank" href="http://twitter.com/unicolored"><button class="btn btn-info btn-lg btn-block"><i class="fa fa-twitter"></i> Suivre unicolored</button></a>
</div>