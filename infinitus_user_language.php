<?php
/**
 * @package infinitus_user_language
 * @version 1.0
 */
/*
Plugin Name: Infinitus User Language
Plugin URI: http://thierrycharbonnel.com/wordpress/plugins/infinitus_user_language/
Description: This is just a plugin, to allows each user to choose their admin language.
Author: Thierry Charbonnel
Version: 1.1
Author URI: http://www.autreplanete.com/
*/


/*  Copyright 2011 autreplanete.com (email : t@ap.cx)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function infinitus_user_language_init(){
	load_plugin_textdomain( 'infinitus_user_language', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'init', 'infinitus_user_language_init' );

function infinitus_user_language_personal_options_update( $user_id ){
	if ( ! isset( $_POST['infinitus_user_language'] ) || empty( $_POST['infinitus_user_language'] ) )
		$locale = null;
	else
		$locale = trim( $_POST['infinitus_user_language'] );
		
	if ( empty( $locale ) )
		$locale = 'en_US';
		
	update_user_option( $user_id, 'infinitus_user_language', $locale, true );
}

add_action( 'personal_options_update', 'infinitus_user_language_personal_options_update' );

function infinitus_user_language_edit_user_profile_update( $user_id ) {
	if ( ! isset( $_POST['infinitus_user_language'] ) || empty( $_POST['infinitus_user_language'] ) )
		$locale = null;
	else
		$locale = trim( $_POST['infinitus_user_language'] );
		
	if ( empty( $locale ) )
		$locale = 'en_US';
		
	update_user_option( $user_id, 'infinitus_user_language', $locale, true );
}

add_action( 'edit_user_profile_update', 'infinitus_user_language_edit_user_profile_update' );


function infinitus_user_language_personal_options( $user ){
	global $current_user;
	get_currentuserinfo();
	?>
	<tr>
	<th scope="row"><?php _e( 'User Language', 'infinitus_user_language' ); ?></th>
	<td>
	<select name="infinitus_user_language" id="infinitus_user_language">
	<?php 
		mu_dropdown_languages( get_available_languages(), get_user_option('infinitus_user_language', $user->ID) ); 
	?>
	</select>
		<span style="display: none;"><?php 
		
		_e( 'Current Language : ', 'infinitus_user_language' );
		echo get_user_option('infinitus_user_language', $user->ID); 
		?>
		</span>
	</td>
	</tr>
	
	<?php 		
}

add_action( 'personal_options', 'infinitus_user_language_personal_options' );


function infinitus_user_language_locale($locale){
	if (!is_admin()) {
		return $locale;
	}
	
	if ( ! function_exists( 'wp_get_current_user' ) )
		return $locale;
	$user_language = get_user_option( 'infinitus_user_language' );
	if ( !empty( $user_language ) ) {
		return $user_language;
	}
	return $locale;

}

add_filter( 'locale', 'infinitus_user_language_locale' );