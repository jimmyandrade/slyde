<?php

namespace jimmyandrade;

/**
 *
 * @author SetordeTI
 *        
 */
class Slider_Widget extends \WP_Widget {
	
	/**
	 * Widget constructor
	 */
	public function __construct() {
		parent::__construct(
				'slider_widget',
				__( 'Simple Slyde Slider', 'slyde'),
				array( 'description' => __( 'Get all the "slide" posts and show the images', 'slyde') )
		);
		add_image_size( 'slide', 1024, 442, true );
	}
	
	public static function register() {
		register_widget( __CLASS__ );
	}
	
	public function widget( $args, $instance ) {
		
		$args = array(
				'posts_per_page' => 6,
				'orderby' => 'menu_order',
				'post_type' => 'slide',
				'post_status' => 'publish',
				'order' => 'ASC',
		);
		$posts_array = get_posts( $args );
		
		if( count( $posts_array ) < 1 ) {
?><div id="no-posts-found"></div>
<?php
			return;
		}
		
		// always set $post as global before using setup postdata. otherwise, post thumbnails won't work
		global $post;
		
		foreach ( $posts_array as $post ) {
			setup_postdata( $post );
			$thumbnail_args = array(
					'class' => 'slide',
					'data-short' => htmlentities( get_the_title() ),
					'data-full' => htmlentities( get_the_excerpt() ),
			);
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'slide', $thumbnail_args );
			}
		} // end foreach
		
		wp_reset_postdata();
		
	} // end public function widget
	
} // end class Slider_Widget

?>