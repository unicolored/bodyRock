<?php

echo a('div.thumbnail');
	echo bodyloopGet_thumbnail($instance);
	
	echo a('div.caption');
		echo '<h3>'.get_the_title().'</h3>';
	
		if ( $instance['excerpt']=='on' ) {
			echo bodyloopGet_excerpt($instance);
		}
	echo z('/div');
echo z('/div');