<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<form method="get" id="searchform" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="field input-medium search-query" name="s" id="s" placeholder="<?php esc_attr_e( 'Rechercher', 'bodyrock' ); ?>" />
		<input type="submit" class="btn submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Rechercher', 'bodyrock' ); ?>" />
	</form>
