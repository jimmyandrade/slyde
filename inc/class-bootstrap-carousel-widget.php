<?php

namespace jimmyandrade;

/**
 * Bootstrap Carousel Slider Widget
 *
 * @author Paulo H. Jimmy Andrade Mota C. <paulojimmyandrade@icloud.com>
 *
 */
class Bootstrap_Carousel_Widget extends Slyde_Base_Widget {

	private $defaults = [];

	public function __construct() {
		$this->defaults['previous_text'] = __( 'Previous slide', 'slyde' );
		$this->defaults['next_text']     = __( 'Next slide', 'slyde' );
		$args                            = [
			'description' => __( 'Show slides in a bootstrap carousel way', 'slyde' ),
		];
		parent::__construct( 'bootstrap_carousel_widget', __( 'Bootstrap Carousel Slider' ), $args );
		add_action( 'widgets_init', [ __CLASS__, 'widgets_init' ] );
	}

	public static function widgets_init() {
		register_widget( __CLASS__ );
	}

	public function widget( $args, $instance ) {
		$the_query = $this->get_posts();
		if ( ! $the_query->have_posts() ) {
			return;
		}
		$carousel_id = isset( $instance['carousel_id'] ) && ! empty( $instance['carousel_id'] ) ? $instance['carousel_id'] : 'carousel-example';
		?>
        <div id="<?php echo esc_attr( $carousel_id ); ?>" class="carousel slide" data-ride="carousel"
             data-interval="5000">
			<?php
			if ( 'yes' === $instance['indicators'] ):
				$this->indicators( $carousel_id, $the_query );
			endif;
			?>
            <div class="carousel-inner">
				<?php
				$counter = 0;
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					?>
                    <div id="slide-<?php the_ID() ?>" <?php post_class( $counter == 0 ? 'active item' : 'item' ); ?>>
						<?php the_post_thumbnail( $instance['image_size'], [ 'role' => 'presentation' ] ); ?>
                        <div class="carousel-caption">
                            <a href="<?php echo get_post_meta( get_the_ID(), '_external_url', true ); ?>"
                               title="<?php the_title_attribute(); ?>">
								<?php if ( 'yes' === $instance['show_title'] ):
									the_title();
								endif; ?>
                            </a>
                        </div>
                    </div>
				<?php }
				wp_reset_postdata(); ?>
            </div>
            <a class="left carousel-control" href="<?php echo esc_attr( '#' . $carousel_id ); ?>"
               data-slide="prev" title="<?php echo esc_attr( $instance['previous_text'] ); ?>">
				<?php if ( $instance['icons_library'] === 'fa' ): ?>
                    <i aria-hidden="true" class="icon-prev fa fa-angle-left"></i>
				<?php else: ?>
                    <i aria-hidden="true" class="glyphicon glyphicon-chevron-left"></i>
				<?php endif; ?>
                <span class="sr-only"><?php echo strip_tags( $instance['previous_text'] ); ?></span>
            </a>
            <a class="right carousel-control" href="<?php echo esc_attr( '#' . $carousel_id ); ?>"
               data-slide="next" title="<?php echo esc_attr( $instance['next_text'] ); ?>">
				<?php if ( $instance['icons_library'] === 'fa' ): ?>
                    <i aria-hidden="true" class="icon-next fa fa-angle-right"></i>
				<?php else: ?>
                    <i aria-hidden="true" class="glyphicon glyphicon-chevron-right"></i>
				<?php endif; ?>
                <span class="sr-only"><?php echo strip_tags( $instance['next_text'] ); ?></span>
            </a>
        </div>
        <div id="after-<?php echo esc_attr( $carousel_id ); ?>"></div>
		<?php
	}

	private function indicators( $carousel_id, $the_query ) {
		$counter = 0;
		?>
        <ol class="carousel-indicators">
			<?php

			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				?>
                <li
                        data-target="<?php echo esc_attr( '#' . $carousel_id ); ?>"
                        data-slide-to="<?php echo esc_attr( $counter ); ?>"
                        class="<?php echo esc_attr( $counter == 0 ? 'active' : '' ); ?>">
                </li>
				<?php
				$counter ++;
			}
			wp_reset_postdata();
			?>
        </ol>
		<?php
	}

	public function form( $instance ) {
		$posts_per_page = isset( $instance['posts_per_page'] ) ? intval( $instance['posts_per_page'] ) : 6;
		$order          = isset( $instance['order'] ) ? sanitize_text_field( $instance['order'] ) : 'menu_order';
		$html_id        = isset( $instance['html_id'] ) ? sanitize_text_field( $instance['html_id'] ) : 'carousel';
		$image_size     = isset( $instance['image_size'] ) ? sanitize_text_field( $instance['image_size'] ) : 'full';
		$previous_text  = isset( $instance['previous_text'] ) ? $instance['previous_text'] : $this->defaults['previous_text'];
		$next_text      = isset( $instance['next_text'] ) ? $instance['next_text'] : $this->defaults['next_text'];
		$icons_library  = isset( $instance['icons_library'] ) ? $instance['icons_library'] : 'glyphicons';
		$indicators     = isset( $instance['indicators'] ) ? $instance['indicators'] : false;
		$show_title     = isset( $instance['show_title'] ) ? $instance['show_title'] : false;
		?>
        <fieldset>
            <!--
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
					<?php esc_html_e( 'Order', 'slyde' ) ?>
                </label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
                        class="widefat">
                    <option <?php selected( $order, 'menu_order' ); ?> value="menu_order">
						<?php esc_html_e( 'User defined order', 'slyde' ) ?>
                    </option>
                </select>
            </p>
            -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ) ?>">
					<?php esc_html_e( 'Slides per page', 'slyde' ); ?>
                </label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ) ?>"
                       class="tiny-text" min="1" max="9" step="1"
                       name="<?php echo esc_attr( $this->get_field_name( 'posts_per_page' ) ) ?>"
                       type="number" value="<?php echo intval( $posts_per_page ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>">
					<?php esc_html_e( 'Slider image size', 'slyde' ); ?>
                </label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
					<?php foreach ( $this->get_image_sizes() as $value => $label ):
						?>
                        <option <?php selected( $image_size, $value ) ?>
                                value="<?php echo esc_attr( $value ) ?>">
							<?php echo apply_filters( 'image_size_label', $label ); ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </p>
        </fieldset>
        <fieldset>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'html_id' ) ); ?>">
					<?php esc_html_e( 'HTML ID attribute', 'slyde' ); ?>
                </label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'html_id' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'html_id' ) ); ?>"
                       value="<?php echo esc_attr( $html_id ); ?>"/>
            </p>
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'indicators' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'indicators' ) ); ?>"
					<?php checked( $indicators, 'yes' ); ?> type="checkbox" value="yes"/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'indicators' ) ); ?>">
					<?php esc_html_e( 'Show indicators', 'slyde' ); ?>
                </label>
            </p>
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>"
					<?php checked( $show_title, 'yes' ); ?> type="checkbox" value="yes"/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>">
					<?php esc_html_e( 'Show slide title/caption', 'slyde' ); ?>
                </label>
            </p>
        </fieldset>
        <fieldset>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'icons_library' ) ) ?>">
					<?php esc_html_e( 'Icons library', 'slyde' ); ?>
                </label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'icons_library' ) ) ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'icons_library' ) ) ?>"
                        class="widefat">
                    <option <?php selected( $icons_library, 'fa' ) ?> value="fa">
						<?php esc_html_e( 'Font Awesome', 'slyde' ); ?>
                    </option>
                    <option <?php selected( $icons_library, 'glyphicons' ) ?> value="glyphicons">
						<?php esc_html_e( 'Glyphicons', 'slyde' ); ?>
                    </option>
                </select>
            </p>
			<?php
			$text = 'Text for "%s" button';
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'previous_text' ) ); ?>">
					<?php printf( _x( $text, 'Previous', 'slyde' ), $this->defaults['previous_text'] ); ?>
                </label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'previous_text' ) ); ?>"
                       class="widefat"
                       name="<?php echo esc_attr( $this->get_field_name( 'previous_text' ) ); ?>"
                       type="text" value="<?php echo esc_attr( $previous_text ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'next_text' ) ); ?>">
					<?php printf( _x( $text, 'Next', 'slyde' ), $this->defaults['next_text'] ); ?>
                </label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'next_text' ) ); ?>"
                       class="widefat"
                       name="<?php echo esc_attr( $this->get_field_name( 'next_text' ) ); ?>"
                       type="text" value="<?php echo esc_attr( $next_text ); ?>"/>
            </p>
        </fieldset>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return [
			'posts_per_page' => isset( $new_instance['posts_per_page'] ) ? $new_instance['posts_per_page'] : 6,
			'order'          => sanitize_text_field( $new_instance['order'] ),
			'post_type'      => sanitize_text_field( $new_instance['post_type'] ),
			'post_status'    => sanitize_text_field( $new_instance['post_status'] ),
			'html_id'        => sanitize_text_field( $new_instance['html_id'] ),
			'image_size'     => isset( $new_instance['image_size'] ) ? $new_instance['image_size'] : 'large',
			'previous_text'  => isset( $new_instance['previous_text'] ) ? $new_instance['previous_text'] : $this->defaults['previous_text'],
			'next_text'      => isset( $new_instance['next_text'] ) ? $new_instance['next_text'] : $this->defaults['next_text'],
			'icons_library'  => isset( $new_instance['icons_library'] ) ? $new_instance['icons_library'] : 'glyphicons',
			'indicators'     => isset( $new_instance['indicators'] ) ? $new_instance['indicators'] : false,
			'show_title'     => isset( $new_instance['show_title'] ) ? $new_instance['show_title'] : false,
		];

	}

}