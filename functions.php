<?php

/**
 * Live and Let's Fly functions and definitions.
 * 
 * @package Live and Let's Fly
 * @since Live and Let's Fly 1.0.0
 */

/**
 * Define theme constants.
 * 
 * @since Live and Let's Fly 1.0.0
 */
define('LIVEANDLETSFLY_VERSION', '2.0.0');
define('LIVEANDLETSFLY_TEXTDOMAIN', 'liveandletsfly');
define('LIVEANDLETSFLY_THEMEROOT', get_stylesheet_directory_uri());

$TRAVELISTA_THEME = wp_get_theme('travelista');
define('TRAVELISTA_VERSION', $TRAVELISTA_THEME->get('Version'));
define('TRAVELISTA_TEXTDOMAIN', $TRAVELISTA_THEME->get('TextDomain'));
define('TRAVELISTA_THEMEROOT', get_template_directory_uri());

/**
 * Live and Let's Fly Enqueue Styles.
 * 
 * @since Live and Let's Fly 1.0.0
 * 
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
 * @link https://codex.wordpress.org/Function_Reference/wp_register_style
 * @link https://codex.wordpress.org/Function_Reference/wp_enqueue_style
 */
function liveandletsfly_enqueue_styles()
{
	// Travelista Theme Styles
	wp_register_style('travelista-main', TRAVELISTA_THEMEROOT . '/style.css', array(), TRAVELISTA_VERSION);
	wp_enqueue_style('travelista-main');

	// Live and Let's Fly Theme Styles
	wp_register_style('liveandletsfly-main', LIVEANDLETSFLY_THEMEROOT . '/css/main.css', array('travelista-main'), LIVEANDLETSFLY_VERSION);
	wp_enqueue_style('liveandletsfly-main');

	if (is_tax('airlines') || is_singular('meals') ||  is_page('matthews-meals') ||  is_page('meals-search')) {
		// Live and Let's Fly Theme custom style
		wp_register_style('liveandletsfly-style', LIVEANDLETSFLY_THEMEROOT . '/css/style.css', array('travelista-style'), LIVEANDLETSFLY_VERSION);
		wp_enqueue_style('liveandletsfly-style');
		wp_enqueue_script('custom-js', LIVEANDLETSFLY_THEMEROOT .  '/js/custom.js', array('jquery'), '', true);
	}
}
add_action('wp_enqueue_scripts', 'liveandletsfly_enqueue_styles');


function enqueuing_admin_scripts()
{
	wp_enqueue_script('custom-js', LIVEANDLETSFLY_THEMEROOT .  '/js/admin.js', array('jquery'), '', true);
}

add_action('admin_enqueue_scripts', 'enqueuing_admin_scripts');


/**
 * Live and Let's Fly Above Content Ad.
 * 
 * @since Live and Let's Fly 1.0.0
 */
function liveandletsfly_above_content_ad()
{
	if (!function_exists('boardingpack_ad_manager')) return;

?>
	<center>
		<?php boardingpack_ad_manager('above_content'); ?>
	</center>
<?php
}
add_action('liveandletsfly_above_content', 'liveandletsfly_above_content_ad', 1);

/**
 * Live and Let's Fly Below Content Ad.
 * 
 * @since Live and Let's Fly 1.0.0
 */
function liveandletsfly_below_content_ad()
{
	if (!function_exists('boardingpack_ad_manager')) return;

?>
	<center>
		<?php boardingpack_ad_manager('below_content'); ?>
	</center>
<?php
}
add_action('liveandletsfly_below_content', 'liveandletsfly_below_content_ad', 1);

/**
 * Live and Let's Fly In Content Ad.
 * 
 * @since Live and Let's Fly 1.0.0
 */
function liveandletsfly_in_content_ad()
{
	if (!function_exists('boardingpack_ad_manager')) return;

?>
	<div class="liveandletsfly-in-content">
		<?php boardingpack_ad_manager('in_content'); ?>
	</div>
<?php
}
add_action('liveandletsfly_in_content', 'liveandletsfly_in_content_ad', 1);

/**
 * Live and Let's Fly Easy Table of Contents Title Filter.
 * 
 * @since Live and Let's Fly 1.0.0
 * 
 * @param str $content The post content.
 */
function liveandletsfly_ez_toc_title_filter($content)
{
	// $content = str_replace( '<p class="ez-toc-title">In this post:</p>', '<span class="ez-toc-title">In this post:</span>', $content );
	$content = preg_replace('/<p class="ez-toc-title">(.*?)<\/p>/', '<span class="ez-toc-title">$1</span>', $content);

	return $content;
}
add_filter('the_content', 'liveandletsfly_ez_toc_title_filter', 101);

/**
 * Live and Let's Fly Attachment Image Link Filter.
 * 
 * @since 1.0.0
 * @author Joshua Fach (jfach@frequentflyerservices.com)
 * 
 * @param string $content The excerpt for the current post.
 */
function liveandletsfly_attachment_image_link_filter($content)
{
	$content = preg_replace(
		array('{<a(.*?)(wp-att|wp-content\/uploads)[^>]*><img}', '{ wp-image-[0-9]*" /></a>}'),
		array('<img', '" />'),
		$content
	);

	return $content;
}
add_filter('the_content', 'liveandletsfly_attachment_image_link_filter');

/**
 * Live and Let's Fly EX.CO Player.
 * 
 * @since Live and Let's Fly 1.0.0
 */
function liveandletsfly_exco_player($content)
{
	if (!in_the_loop() || !is_main_query()) return $content;
	if (!is_singular(array('post'))) return $content;

	ob_start();
?>
	<script>
		(function(d, s, n) {
			var js, fjs = d.getElementsByTagName(s)[0];
			js = d.createElement(s);
			js.className = n;
			js.src = "//player.ex.co/player/7dd533d8-f47e-4e6a-b296-8e17f70cea4d";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'exco-player'));
	</script>
	<div id="7dd533d8-f47e-4e6a-b296-8e17f70cea4d"></div>

	<style type="text/css">
		body.adhesion .pbs[data-pbs-position="sticky"] .pbs__player {
			bottom: 107px !important;
		}

		@media (max-width: 767px) {
			body.adhesion .pbs[data-pbs-position="sticky"] .pbs__player {
				bottom: 67px !important;
			}
		}
	</style>
<?php
	$exco_player = ob_get_clean();

	/*
	$id = 2;
	$paragraphs = explode( '</p>', $content );
	foreach ( $paragraphs as $index => $paragraph ) {
		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= '</p>';
		}
		if ( $id == $index + 1 ) {
			$paragraphs[$index] .= $exco_player;
		}
	}
	return implode( '', $paragraphs );
	*/

	return $content . $exco_player;
}
// add_filter( 'the_content', 'liveandletsfly_exco_player' );

/* Live and Let's Fly Republish */
include_once get_stylesheet_directory() . '/liveandletsfly-republish.php';

/* Yoast SEO Remove Reply to Comment */
add_filter('wpseo_remove_reply_to_com', '__return_false');


// Registor custom post type
require get_stylesheet_directory() . '/inc/custom-post-types.php';

// Custom Functions List
require get_stylesheet_directory() . '/inc/custom-functions.php';
