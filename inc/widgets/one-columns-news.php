<?php

add_action( 'widgets_init', 'Khulnagazette_one_column_news_widget' );

function Khulnagazette_one_column_news_widget() {
    register_widget( 'Khulnagazette_one_column_news' );
}

class Khulnagazette_one_column_news extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'Khulnagazette_one_column_news',
            'description' => __( 'One column news section', 'khulnagazette' )
        );
        parent::__construct( 'Khulnagazette_one_column_news', __( 'KG: One columns news', 'khulnagazette' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'section_title_one' => array(
                'scholarship_widgets_name'         => 'section_title_one',
                'scholarship_widgets_title'        => __( 'News Title', 'khulnagazette' ),
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
                <div class="row">
                   <?php 
                    $col_one_args = array(
                        'post_type'       => 'post',
                        'posts_per_page'  => 5,
                        'post_status'     => 'publish',
                        'order'           => 'DESC',
                        'no_found_rows'   => true,
                    );
                    if ( ! empty( $section_cat_slug_one ) ) {
                        $col_one_args['category_name'] = sanitize_title( $section_cat_slug_one );
                    }
                    
                    $col_one_query = new WP_Query( $col_one_args );
                    if($col_one_query->have_posts()){
                    $sl_one = 0;
                    $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                    ?>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="khala-title">
                                   <a href="<?php echo esc_url( home_url( '/category/' . $section_cat_slug_one ) ); ?>"><h2><?php echo esc_html($section_title_one);?></h2></a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="khala-hayper">
                        <?php while($col_one_query->have_posts()): $col_one_query->the_post();
                                $post_id_one = get_the_ID();
                                $sl_one = $sl_one+1;
                                $thumb_size = ( $sl_one == 1 ) ? 'khulna_gazette_lead_thumb' : 'khulna_gazette_post_thumb';
                                $img_src = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_one, $thumb_size ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
                            ?>
                            
                        <?php if($sl_one==1){ ?>
                        <div class="col-md-6 col-12">
                            <div class="khala-box">
                                <a href="<?php the_permalink();?>" class="kg-lead-link">
                                    <div class="kg-lead-thumb-wrap">
                                        <img src="<?php echo esc_url($img_src); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async" class="kg-lead-img">
                                    </div>
                                    <h4><?php the_title();?></h4>
                                </a>
                                <p><?php the_excerpt();?></p>
                            </div>
                        </div> <!-- End Col-6 -->
                        

                        <div class="col-md-6 col-12">
                            <div class="row">
                            <?php } else{ ?>
                                <div class="col-md-6 col-6">
                                    <a href="<?php the_permalink();?>">
                                        <div class="khala-right-box">
                                            <img src="<?php echo esc_url($img_src); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
                                            <p><?php the_title();?></p>
                                        </div>
                                    </a>
                                </div> <!-- End col-6 -->
                            <?php }
                                endwhile;
                                wp_reset_postdata();
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <section class="empty-30"></section>
                 
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
