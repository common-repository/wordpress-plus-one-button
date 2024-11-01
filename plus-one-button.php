<?php
/* 
Plugin Name: 	WordPress Plus One Button
Plugin URI: 	http://wordpress.org/extend/plugins/plusone-button/
Description: 	Adds "Google Plus One Button" below every post on your WordPress Site.
Version: 		0.0.1
Author: 		Ashish Thakur
Author URI: 	http://farandaway.in/
License: 		GPLv2
*/

// Settings and/or Configuration Details go here
define('PLUSONE_TEMPLATE','<div class="g-plusone" data-href=%s data-size=%s data-annotation=%s></div>');

athakur_plus_one::init();

class athakur_plus_one {
	static $href		= '';
	static $size 		= 'standard';
	static $annotation	= 'inline';
	
	
	/* *
	 * Initialization Function to hook into WordPress.
	 */
	static function init()
	{
		// Tie into WordPress Hooks and any functions that should run on load.
		add_filter('the_content', 'athakur_plus_one::plusone_get_button');
		add_action('init', 'athakur_plus_one::add_plusone_js_head');		
	}
	
	/**
	 * Function to return the URL of the post to be shared on the Google Plus
	 * @return the post URL
	 */
	static function plusone_get_post_url()
	{
		global $post;
		return get_permalink($post->ID);
	}
	
	/**
	 * Add the local plusone.js to the <head> of WordPress Pages.
	 * @return none
	 * 
	 */
	static function add_plusone_js_head()
	{
		$src = plugins_url('plusone.js', __FILE__);
		wp_register_script('plusone',$src);
		wp_enqueue_script('plusone');		
	}
	
	/**
	 * Add Plus one below your post on WordPress Site
	 * 
	 */
	 static function plusone_get_button($content)
	 {
		 self::$href = athakur_plus_one::plusone_get_post_url();
		 return $content . sprintf(PLUSONE_TEMPLATE,self::$href,self::$size,self::$annotation);
	 }
}

/*EOF*/




