<?php
require_once('metabox-save.php');

// Creating the Custom Field Box
add_action("admin_init", "client_meta_box");   

function client_meta_box(){
    add_meta_box("clientInfo-meta", "Options", "client_meta_options", "clients", "side", "high");
}  

function client_meta_options(){
        global $post;
		global $wpdb;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $startdate = $custom["clientstartDate"][0];
        $enddate = $custom["clientendDate"][0];
        $clientlieuId = $custom["clientlieuId"][0];
//        $clientlieuIdName = $custom["clientlieuIdName"][0];
        $siteweb = $custom["sitewebclient"][0];
        $telephone = $custom["telephoneclient"][0];
        $gratuit = $custom["gratuitclient"][0];
        $tarifs = $custom["tarifsclient"][0];
        $horaires = $custom["horairesclient"][0];
        $lienaffiche = $custom["lienafficheclient"][0];
		if(strpos($clientlieuId,',')>0) {
			$e=explode(',',$clientlieuId);
			$clientlieuId=$e[0];
		}
?>
<?php wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE ); ?><!--
<h4 class="ai1ec-section-title"><?php _e( 'Date et heure de l\'évènement', AI1EC_PLUGIN_NAME ); ?></h4>
<table class="ai1ec-form">
	<tbody>
		<tr>
			<td class="ai1ec-first">
				<label for="ai1ec_all_day_client">
					<?php _e( 'Toute la journée', AI1EC_PLUGIN_NAME ); ?>?
				</label>
			</td>
			<td>
				<input type="checkbox" name="ai1ec_all_day_client" id="ai1ec_all_day_client" <?php echo $all_day_client; ?> />
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
		<tr id="ai1ec_end_holder" <?php if( ! $repeating_client ) echo 'class="ai1ec_hidden"' ?>>
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
    <label>Début :</label><input name="clientstartDate" value="<?php echo $startdate; ?>" />
    <br>
    <label>Fin :</label><input name="clientendDate" value="<?php echo $enddate; ?>" />
<?php

		$querystr = "
    SELECT $wpdb->posts.ID, $wpdb->posts.post_title  
    FROM $wpdb->posts
    WHERE $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'lieux'
	ORDER BY $wpdb->posts.post_name DESC
 ";
//		echo $clientlieu;

		$PA = $wpdb->get_results($querystr, OBJECT);
		if ($PA){ 
		?>
        <hr>
        <label>Lieu :</label>
        <select name="clientlieuId">
        <?php
			foreach ($PA as $P){
?>
    <option <?php echo ($clientlieuId==$P->ID ? 'selected="selected"' : false); ?> value="<?php echo $P->ID ?>" /><?php echo $P->post_title; ?>
<?php
			}
		?>
        </select>
     <br>
    <label>Site Web :</label><input name="sitewebclient" value="<?php echo $siteweb; ?>" />
     <br>
    <label>Téléphone :</label><input name="telephoneclient" value="<?php echo $telephone; ?>" />
     <br>
    <label>Gratuit :</label><input name="gratuitclient" value="<?php echo $gratuit; ?>" />
    <br>
    <label>Tarifs :</label><textarea name="tarifsclient" ><?php echo $tarifs; ?></textarea>
    <br>
    <label>Horaires :</label><textarea name="horairesclient" ><?php echo $horaires; ?></textarea>
    <br>
    <label>Lien affiche :</label><textarea name="lienafficheclient" ><?php echo $lienaffiche; ?></textarea>
        
        <?php
		}
    }

?>