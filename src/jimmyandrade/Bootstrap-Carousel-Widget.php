<?php

namespace jimmyandrade;

/**
 * Bootstrap Carousel Slider Widget
 *
 * @author Paulo H. Jimmy Andrade Mota C. <paulojimmyandrade@icloud.com>
 *        
 */
class Bootstrap_Carousel_Widget extends \WP_Widget {
	
	public function __construct() {
		$args = array(
				'description' => __( 'Show slides in a bootstrap carousel way', 'slyde' ),			
		);
		parent::__construct( 'bootstrap_carousel_widget', __( 'Bootstrap Carousel Slide' ), $args );
	}
	
	public function widget( $args, $instance ) {
		
		$carousel_id_attr = $instance['carousel_id'];
		
		
		$posts = get_posts( $instance );
		
?>
<div id="<?php echo esc_attr( $instance['carousel_id'] ); ?>" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
	<?php
	for ($counter = 0; $counter <= count( $posts ); $counter++ ) {
	?>
		<li
			data-target="<?php echo esc_attr( '#' . $carousel_id_attr ); ?>"
			data-slide-to="<?php echo esc_attr( $counter ); ?>"
			class="<?php echo esc_attr( $counter == 0 ? 'active' : '' );  ?>">
		</li>
	<?php
	}
	?>
	</ol>
	<div class="carousel-inner">
	<?php
	$counter = 0;
	foreach ( $posts as $post ) { setup_postdata($post); ?>
		<div id="slide-<?php echo $post->ID ?>" <?php post_class( $counter == 0 ? 'active item' : 'item' ); ?>>
			<?php the_post_thumbnail( $instance['image_size'] , array( 'role'=>'presentation' ) ); ?>
			<div class="carousel-caption">
				<a href="<?php echo get_post_meta(get_the_ID(), '_external_url', true); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</div>
		</div>
	<?php } wp_reset_postdata(); ?>
	</div>	
	<a class="left carousel-control" href="<?php echo esc_attr( '#' . $carousel_id_attr ); ?>" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" role="presentation"></span>
		<span class="sr-only"><?php echo strip_tags( $instance['previous_text'] ); ?></span>
	</a>
	<a class="right carousel-control" href="<?php echo esc_attr( '#' . $carousel_id_attr ); ?>" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" role="presentation"></span>
		<span class="sr-only"><?php echo strip_tags( $instance['next_text'] ); ?></span>
	</a>
</div>		
<?php
	}
	
	public function form( $instance ) {
		$posts_per_page = isset( $instance['posts_per_page'] ) ? intval( $instance['posts_per_page'] ) : 7;
		$order          = isset( $instance['order'] ) ? sanitize_text_field( $instance['order'] ) : 'menu_order';
		$post_type      = isset( $instance['post_type'] ) ? sanitize_text_field( $instance['post_type'] ) : 'slides';
		$post_status    = isset( $instance['post_status'] ) ? sanitize_text_field( $instance['post_status'] ) : 'publish';
		$carousel_id    = isset( $instance['carousel_id'] ) ? sanitize_text_field( $instance['carousel_id'] ) : 'carousel';
		$image_size     = isset( $instance['image_size'] ) ? sanitize_text_field( $instance['image_size'] ) : 'carousel-image';
		$previous_text  = isset( $instance['previous_text'] ) ? sanitize_text_field( $instance['previous_text'] ) : __( 'Previous', 'slyde' );
		$next_text      = isset( $instance['next_text'] ) ? sanitize_text_field( $instance['next_text'] ) : __( 'Next', 'slyde' );
	}
	
	public function update( $new_instance, $old_instance ) {
		
		return array(
				'posts_per_page' => intval( $new_instance['posts_per_page'] ),
				'order' => sanitize_text_field( $new_instance['order'] ),
				'post_type' => sanitize_text_field( $new_instance['post_type'] ),
				'post_status' => sanitize_text_field( $new_instance['post_status'] ),
				'carousel_id' => sanitize_text_field( $new_instance['carousel_id'] ),
				'image_size' => sanitize_text_field( $new_instance['image_size'] ),
				'previous_text' => sanitize_text_field( $new_instance['previous_text'] ),
				'next_text' => sanitize_text_field( $new_instance['next_text'] ),
		);
		
	}
	
	public static function register() {
		add_action( 'widgets_init', function(){
			register_widget( __CLASS__ );
		});
	}
	
}