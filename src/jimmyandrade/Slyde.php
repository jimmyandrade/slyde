<?php

namespace jimmyandrade;

require_once 'Bootstrap-Carousel-Widget.php';
require_once 'Slider-Widget.php';

/**
 * Slyde main class
 *
 * @author Paulo H. Jimmy Andrade Mota C. <contato@jimmyandrade.com>
 *
 */
class Slyde {

	private static $instance = false;

	public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	private function __clone() {

	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'after_setup_theme', [ __CLASS__, 'after_setup_theme' ] );
		add_action( 'init', [ __CLASS__, 'init' ] );
		add_action( 'widgets_init', [ __CLASS__, 'widgets_init' ] );
	}

	public static function after_setup_theme() {
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
	}

	public static function init() {

				$labels = [
						'name' => __( 'Slides', 'slyde' ),
						'singular_name' => __( 'Slides', 'slyde' ),
						'menu_name' => __( 'Slides', 'slyde' ),
						'name_admin_bar' => __( 'Slide', 'slyde' ),
						'all_items' => __( 'All Slides', 'slyde' ),
						'add_new' => _x( 'Add New', 'slyde' ),
						'add_new_item' => __( 'Add New Slide', 'slyde' ),
						'edit_item' => __( 'Edit Slide', 'slyde' ),
						'new_item' => __( 'New Slide', 'slyde' ),
						'view_item' => __( '', 'slyde' ),
						'search_items' => __( 'Search Slides', 'slyde' ),
						'not_found' => __( 'No slides found', 'slyde' ),
						'not_found_in_trash' => __( 'No slides found in Trash', 'slyde' ),
						'parent_item_colon' => __( 'Parent Slide', 'slyde' ),
				];
				$rewrite = [
						'slug' => 'slides',
						'with_front' => false,
						'feeds' => false,
						'pages' => false,
				];
				$args = [
						'label' => __( 'Slides', 'slyde' ),
						'labels' => $labels,
						'description' => __( 'Set of images and content to be used as website slides', 'slyde' ),
						'public' => true,
						'exclude_from_search' => true,
						'publicly_queryable' => false,
						'show_ui' => true,
						'show_in_nav_menus' => true,
						'show_in_menu' => true,
						'show_in_admin_bar' => true,
						'menu_position' => 5,
						'menu_icon' => 'dashicons-images-alt',
						'capability_type' => 'post',
						'hierarchical' => false,
						'supports' => array( 'title', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
						'has_archive' => false,
						# 'rewrite' => $rewrite,
						'rewrite' => false, // set to false to prevent call to add_rewrite_tag on a non-object
						'query_var' => false,
						'can_export' => true,
				];
				register_post_type( 'slide', $args );
	}

	public static function widgets_init() {
		Slider_Widget::register();
		Bootstrap_Carousel_Widget::register();
	}

}
