<?php

namespace jimmyandrade;

class Slyde_Base_Widget extends \WP_Widget {

	protected function get_posts() {

		$args = [
			'posts_per_page' => 6,
			'orderby'        => 'menu_order',
			'post_type'      => 'slide',
			'post_status'    => 'publish',
			'order'          => 'ASC',
		];

		return new \WP_Query( $args );
	}

	protected function get_image_sizes() {
		return apply_filters( 'image_size_names_choose', [
			'full'   => __( 'Full Size' ),
			'large'  => __( 'Large' ),
			'medium' => __( 'Medium' ),
		] );
	}

}