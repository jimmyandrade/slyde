<?php

namespace jimmyandrade;

/**
 * Simple Slyde Slider widget
 *
 * @author Paulo H. Jimmy Andrade Mota C. <paulojimmyandrade@icloud.com>
 *
 */
class Slider_Widget extends Slyde_Base_Widget {

	/**
	 * Widget constructor
	 */
	public function __construct() {
		$construct_array = [
			'description' => __( 'Get all the "slide" posts and show the images', 'slyde' ),
		];
		parent::__construct( 'slider_widget', __( 'Simple Slyde Slider', 'slyde' ), $construct_array );
	}

	public static function widgets_init() {
		register_widget( __CLASS__ );
	}

	public function widget( $args, $instance ) {


		$posts_array = get_posts( $args );

		if ( count( $posts_array ) < 1 ) {
			?>
            <div id="no-posts-found"></div>
			<?php
			return;
		}

		// always set $post as global before using setup postdata. otherwise, post thumbnails won't work
		global $post;

		foreach ( $posts_array as $post ) {
			setup_postdata( $post );
			$thumbnail_args = [
				'class'      => 'slide',
				'data-short' => htmlentities( get_the_title() ),
				'data-full'  => htmlentities( get_the_excerpt() ),
			];
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( $instance['image_size'], $thumbnail_args );
			}
		} // end foreach

		wp_reset_postdata();

	} // end public function widget

} // end class Slider_Widget
