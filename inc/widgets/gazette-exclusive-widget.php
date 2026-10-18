<?php

add_action( 'widgets_init', 'Khulnagazette_exclusive_news_widget' );

function Khulnagazette_exclusive_news_widget() {
    register_widget( 'Khulnagazette_exclusive_news' );
}

class Khulnagazette_exclusive_news extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'Khulnagazette_exclusive_news',
            'description' => __( 'Gazette Exclusive', 'khulnagazette' )
        );
        parent::__construct( 'Khulnagazette_exclusive_news', __( 'Gazette Exclusive', 'khulnagazette' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'section_title_one' => array(
                'scholarship_widgets_name'         => 'section_title_one',
                'scholarship_widgets_title'        => __( 'Exclusive Title', 'khulnagazette' ),
                'scholarship_widgets_field_type'   => 'text'
            ),

            'section_cat_slug_one' => array(
                'scholarship_widgets_name'         => 'section_cat_slug_one',
                'scholarship_widgets_title'        => __( 'News Category', 'khulnagazette' ),
                'scholarship_widgets_default'      => '',
                'scholarship_widgets_field_type'   => 'category_dropdown'
            ),
            
        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $section_title_one = empty( $instance['section_title_one'] ) ? '' : $instance['section_title_one'];

        $section_cat_slug_one = empty( $instance['section_cat_slug_one'] ) ? '' : $instance['section_cat_slug_one'];



        echo $before_widget;

    ?>
<div class="kg-exclusive-news-widget">
	<?php 
			$col_one_args = array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'no_found_rows'  => true,
			);
			if ( ! empty( $section_cat_slug_one ) ) {
				$col_one_args['category_name'] = sanitize_title( $section_cat_slug_one );
			}

			$query = new WP_Query( $col_one_args );
			if($query->have_posts()){

			?>

	<div class="row">
		<div class="col-md-12">
			<div class="gazette-exclusive-wrapper">

				<h2><?php echo esc_html($section_title_one);?></h2>
                
				<?php while($query->have_posts()): $query->the_post();
						$post_id_one = get_the_ID();
						$post_img_url = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_one, 'khulna_gazette_post_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
						$default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
				?>
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<div class="gazette-tab-content-box">
						<img src="<?php echo esc_url($post_img_url); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" width="120" height="66" loading="lazy" decoding="async">
						<p><?php echo esc_html(get_the_title()); ?></p>
					</div>
				</a>
				<?php

				endwhile;
				wp_reset_postdata();
				}

				?>
                
			</div>
		</div>

	</div>
</div>

<section class=" empty-30"></section>

<?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    scholarship_widgets_updated_field_value()      defined in scholarship-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$scholarship_widgets_name] = scholarship_widgets_updated_field_value( $widget_field, $new_instance[$scholarship_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    scholarship_widgets_show_widget_field()        defined in scholarship-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $scholarship_widgets_field_value = !empty( $instance[$scholarship_widgets_name] ) ? wp_kses_post( $instance[$scholarship_widgets_name] ) : '';
            scholarship_widgets_show_widget_field( $this, $widget_field, $scholarship_widgets_field_value );
        }
    }
}
