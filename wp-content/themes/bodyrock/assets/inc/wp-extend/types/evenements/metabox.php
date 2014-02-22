<?php
require_once('metabox-save.php');

// Creating the Custom Field Box
add_action("admin_init", "evenement_meta_box");   

function evenement_meta_box(){
    add_meta_box("eventInfo-meta", "Options", "evenement_meta_options", "evenements", "side", "high");
}  

function evenement_meta_options(){
        global $post;
		global $wpdb;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $startdate = $custom["eventstartDate"][0];
        $enddate = $custom["eventendDate"][0];
        $eventlieuId = $custom["eventlieuId"][0];
//        $eventlieuIdName = $custom["eventlieuIdName"][0];
        $siteweb = $custom["sitewebEvent"][0];
        $telephone = $custom["telephoneEvent"][0];
        $gratuit = $custom["gratuitEvent"][0];
        $tarifs = $custom["tarifsEvent"][0];
        $horaires = $custom["horairesEvent"][0];
        $lienaffiche = $custom["lienafficheEvent"][0];
		if(strpos($eventlieuId,',')>0) {
			$e=explode(',',$eventlieuId);
			$eventlieuId=$e[0];
		}
?>
<?php wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE ); ?><!--
<h4 class="ai1ec-section-title"><?php _e( 'Date et heure de l\'évènement', AI1EC_PLUGIN_NAME ); ?></h4>
<table class="ai1ec-form">
	<tbody>
		<tr>
			<td class="ai1ec-first">
				<label for="ai1ec_all_day_event">
					<?php _e( 'Toute la journée', AI1EC_PLUGIN_NAME ); ?>?
				</label>
			</td>
			<td>
				<input type="checkbox" name="ai1ec_all_day_event" id="ai1ec_all_day_event" <?php echo $all_day_event; ?> />
			</td>
		</tr>
		<tr>
			<td>
				<label for="ai1ec_start-date-input">
					<?php _e( 'Heure/Date de début', AI1EC_PLUGIN_NAME ); ?>:
				</label>
			</td>
			<td>
				<input type="text" class="ai1ec-date-input" id="ai1ec_start-date-input" />
				<input type="text" class="ai1ec-time-input" id="ai1ec_start-time-input" />
				<small><?php echo $timezone ?></small>
				<input type="hidden" name="ai1ec_start_time" id="ai1ec_start-time" value="<?php echo $start_timestamp ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="ai1ec_end-date-input">
					<?php _e( 'Heure/Date de fin', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<input type="text" class="ai1ec-date-input" id="ai1ec_end-date-input" />
				<input type="text" class="ai1ec-time-input" id="ai1ec_end-time-input" />
				<small><?php echo $timezone ?></small>
				<input type="hidden" name="ai1ec_end_time" id="ai1ec_end-time" value="<?php echo $end_timestamp ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="ai1ec_repeat">
					<?php _e( 'Répéter', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<?php echo $repeat; ?>
			</td>
		</tr>
		<tr id="ai1ec_end_holder" <?php if( ! $repeating_event ) echo 'class="ai1ec_hidden"' ?>>
			<td>
				<label for="ai1ec_end">
					<?php _e( 'Fin', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
			  <?php echo $end ?>
			</td>
		</tr>
		<tr id="ai1ec_count_holder" <?php if( $ending != 1 ) echo 'class="ai1ec_hidden"' ?>>
			<td>
				<label for="ai1ec_count">
					<?php _e( 'Termine après', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<?php echo $count; ?>
			</td>
		</tr>
		<tr id="ai1ec_until_holder" <?php if( $ending != 2 ) echo 'class="ai1ec_hidden"' ?>>
			<td>
				<label for="ai1ec_until-date-input">
					<?php _e( 'En date', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<input type="text" class="ai1ec-date-input" id="ai1ec_until-date-input" />
				<input type="hidden" name="ai1ec_until_time" id="ai1ec_until-time" value="<?php echo !is_null( $until ) && $until > 0 ? $until : '' ?>" />
			</td>
		</tr>
	</tbody>
</table>

-->
<!-- -->
    <label>Début :</label><input name="eventstartDate" value="<?php echo $startdate; ?>" />
    <br>
    <label>Fin :</label><input name="eventendDate" value="<?php echo $enddate; ?>" />
<?php

		$querystr = "
    SELECT $wpdb->posts.ID, $wpdb->posts.post_title  
    FROM $wpdb->posts
    WHERE $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'lieux'
	ORDER BY $wpdb->posts.post_name DESC
 ";
//		echo $eventlieu;

		$PA = $wpdb->get_results($querystr, OBJECT);
		if ($PA){ 
		?>
        <hr>
        <label>Lieu :</label>
        <select name="eventlieuId">
        <?php
			foreach ($PA as $P){
?>
    <option <?php echo ($eventlieuId==$P->ID ? 'selected="selected"' : false); ?> value="<?php echo $P->ID ?>" /><?php echo $P->post_title; ?>
<?php
			}
		?>
        </select>
     <br>
    <label>Site Web :</label><input name="sitewebEvent" value="<?php echo $siteweb; ?>" />
     <br>
    <label>Téléphone :</label><input name="telephoneEvent" value="<?php echo $telephone; ?>" />
     <br>
    <label>Gratuit :</label><input name="gratuitEvent" value="<?php echo $gratuit; ?>" />
    <br>
    <label>Tarifs :</label><textarea name="tarifsEvent" ><?php echo $tarifs; ?></textarea>
    <br>
    <label>Horaires :</label><textarea name="horairesEvent" ><?php echo $horaires; ?></textarea>
    <br>
    <label>Lien affiche :</label><textarea name="lienafficheEvent" ><?php echo $lienaffiche; ?></textarea>
        
        <?php
		}
    }

?>