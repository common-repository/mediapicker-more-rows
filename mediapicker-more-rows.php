<?php
/*
Plugin Name: 		Mediapicker More Rows
Version: 			0.3
Description: 		Change the number of media items per page that are shown in the mediapicker.
Author: 			Codepress
Author URI: 		http://www.codepress.nl
Text Domain: 		mediapicker-more-rows
Domain Path: 		/languages
License:			GPLv2

Copyright 2012  Codepress  info@codepress.nl

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'CPMPL_TEXTDOMAIN', 'mediapicker-more-rows' );

// only run plugin in the admin interface
if ( !is_admin() )
	return false;

/**
 * Codepress_Mediapicker_Limit
 *
 * @since     0.1
 *
 */
class Codepress_Mediapicker_Limit
{
	private $limit;
	
	/**
	 * Constructor
	 *
	 * @since     0.1
	 */
	function __construct()
	{
		$this->limit = $this->get_limit();
		
		// translations
		load_plugin_textdomain( CPMPL_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
		// set row limit
		add_filter( 'post_limits', array( $this, 'set_row_limit_mediapicker' ), 999, 1 );
		
		// set pagination limit
		add_filter( 'media_upload_mime_type_links', array( $this, 'set_paginate_limit_mediapicker' ), 1 );
	
		// add option to media settings
		add_action('admin_init', array( $this, 'add_media_setting_option' ) );
		
		// add quick settings link
		add_filter( 'plugin_action_links',  array( $this, 'add_settings_link'), 1, 2);		
	}
	
	/**
	 * Set paginate to new limit
	 *
	 * We use the media_upload_mime_type_links-hook to change the 
	 * global $wp_query->found_posts variable.
	 * The actual $type_links variable has no use here.
	 *
	 * @since     0.1
	 */
	public function set_paginate_limit_mediapicker( $type_links )
	{	
		global $wp_query;		
				
		if( $this->screen_is_mediapicker() ) {
			$wp_query->found_posts = $wp_query->found_posts / ( $this->limit / 10 );			
		}
		
		return $type_links;	
	}	
	
	/**
	 * Set row limit mediapicker
	 *
	 * @since     0.1
	 */
	public function set_row_limit_mediapicker($limits)
	{
		if( $this->screen_is_mediapicker() ) {
			
			$paged 	= isset($_GET['paged']) ? $_GET['paged'] : 1;			
			$limit 	= $this->limit * ($paged - 1);
			
			// new limit
			$limits = "LIMIT {$limit}, {$this->limit}";			
		}

		return $limits;
	}	
	
	/**
	 * Check if current screen is the mediapicker
	 *
	 * @since     0.1
	 */
	private function screen_is_mediapicker() 
	{
		global $current_screen;
		
		if( isset($current_screen->id) && 'media-upload' == $current_screen->id && isset($_GET['tab']) && 'library' == $_GET['tab'] )
			return true;
		
		return false;
	}
	
	/**
	 * Add media settings option
	 *
	 * @since     0.1
	 */
	public function add_media_setting_option()
	{
		// add setting; page, name, callback
		register_setting( 'media', 'cpmpl_options',	array( $this, 'validate_input' ) );
		
		// add section; id, title, callback, page
		add_settings_section( 'mediapicker', __( 'Mediapicker', CPMPL_TEXTDOMAIN), '__return_null', 'media'	);
		
		// add field; id, title, callback, page, section
		add_settings_field(	
			'cpmpl_mediapicker_limit', 
			__('Mediapicker show per page', CPMPL_TEXTDOMAIN ),		
			array( $this, 'display_option_field' ),
			'media',
			'mediapicker'
		);
	}
	
	/**
	 * Validate input field
	 *
	 * @since     0.1
	 */
	public function validate_input( $input )
	{		
		if ( !empty( $input['mediapicker_limit'] ) && is_numeric( $input['mediapicker_limit'] ) ) {
			$input['mediapicker_limit'] = abs( $input['mediapicker_limit'] );
			return $input;
		}
		
		return false;
	}	
	
	/**
	 * Display input field
	 *
	 * @since     0.1
	 */
	public function display_option_field()
	{		
		echo "
			<input class='small-text' id='mediapicker_limit' name='cpmpl_options[mediapicker_limit]' type='text' value='{$this->limit}' />
			" . __('items', CPMPL_TEXTDOMAIN) . "
			<p class='description'>
			" . sprintf( __('Maximum number of items that are displayed per page in the mediapicker. Default is %s items.', CPMPL_TEXTDOMAIN), '<code>10</code>' ) . "
			</p>
		";
	}
	
	/**
	 * Get limit
	 *
	 * @since     0.1
	 */
	private function get_limit()
	{
		$options 	= get_option( 'cpmpl_options' );
		
		$value 		= 10; // default	
		if ( !empty($options['mediapicker_limit']) ) {
			$value = trim( esc_attr( $options['mediapicker_limit'] ) );
		}
		
		return apply_filters( 'cp_mediapicker_limit', $value );
	}
	
	/**
	 * Add Settings link to plugin page
	 *
	 * @since     0.1
	 */
	public function add_settings_link( $links, $file ) 
	{
		if ( $file != plugin_basename( __FILE__ ))
			return $links;

		array_unshift( $links, '<a href="' . admin_url("options-media.php#mediapicker_limit") . '">' . __( 'Settings', CPMPL_TEXTDOMAIN) . '</a>' );
		
		return $links;
	}
}
new Codepress_Mediapicker_Limit();

?>