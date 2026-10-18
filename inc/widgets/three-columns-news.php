<?php
/**
 * Widget for sponsors
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

add_action( 'widgets_init', 'kg_three_columns_widget' );

function kg_three_columns_widget() {
    register_widget( 'kg_three_columns_news_widget' );
}

class kg_three_columns_news_widget extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'kg_three_columns_news_widget',
            'description' => __( 'Three columns news section', 'khulnagazette' )
        );
        parent::__construct( 'kg_three_columns_news_widget', __( 'KG: Three columns news', 'khulnagazette' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'section_title_one' => array(
                'scholarship_widgets_name'         => 'section_title_one',
                'scholarship_widgets_title'        => __( 'News Title One', 'khulnagazette' ),
                'scholarship_widgets_field_type'   => 'text'
            ),

            'section_cat_slug_one' => array(
                'scholarship_widgets_name'         => 'section_cat_slug_one',
                'scholarship_widgets_title'        => __( 'News Category', 'khulnagazette' ),
                'scholarship_widgets_default'      => '',
                'scholarship_widgets_field_type'   => 'category_dropdown'
            ),
            
            'section_title_two' => array(
                'scholarship_widgets_name'         => 'section_title_two',
                'scholarship_widgets_title'        => __( 'News Title Two', 'khulnagazette' ),
                'scholarship_widgets_field_type'   => 'text'
            ),

            'section_cat_slug_two' => array(
                'scholarship_widgets_name'         => 'section_cat_slug_two',
                'scholarship_widgets_title'        => __( 'News Category', 'khulnagazette' ),
                'scholarship_widgets_default'      => '',
                'scholarship_widgets_field_type'   => 'category_dropdown'
            ),
            
            'section_title_three' => array(
                'scholarship_widgets_name'         => 'section_title_three',
                'scholarship_widgets_title'        => __( 'News Title Three', 'khulnagazette' ),
                'scholarship_widgets_field_type'   => 'text'
            ),

            'section_cat_slug_three' => array(
                'scholarship_widgets_name'         => 'section_cat_slug_three',
                'scholarship_widgets_title'        => __( 'News Category', 'khulnagazette' ),
                'scholarship_widgets_default'      => '',
                'scholarship_widgets_field_type'   => 'category_dropdown'
            )
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
        
        $section_title_two = empty( $instance['section_title_two'] ) ? '' : $instance['section_title_two'];

        $section_cat_slug_two   = empty( $instance['section_cat_slug_two'] ) ? '' : $instance['section_cat_slug_two'];
        
        $section_title_three = empty( $instance['section_title_three'] ) ? '' : $instance['section_title_three'];

        $section_cat_slug_three   = empty( $instance['section_cat_slug_three'] ) ? '' : $instance['section_cat_slug_three'];


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
                    ?>
                    <div class="col-md-4">
                        <div class="jation-rajneti-title">

                          <a href="<?php echo esc_url( home_url( '/category/' . $section_cat_slug_one ) ); ?>"><h2><?php echo esc_html($section_title_one);?></h2></a>
                          
                           <?php while($col_one_query->have_posts()): $col_one_query->the_post();
                                $post_id_one = get_the_ID();
                                $sl_one = $sl_one+1;
                                
                                $thumb_size_one = ( $sl_one == 1 ) ? 'khulna_gazette_lead_thumb' : 'khulna_gazette_post_thumb';
                                $img_src_one = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_one, $thumb_size_one ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
                                $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                            ?>
                            
                            <?php if($sl_one==1){ ?>
                            <a href="<?php the_permalink(); ?>" class="kg-lead-link">
                                <div class="kg-lead-thumb-wrap">
                                    <img src="<?php echo esc_url($img_src_one); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async" class="kg-lead-img">
                                </div>
                                <h4><?php the_title(); ?></h4>
                            </a>
                            <?php }
        
                            else{
                            ?>
                            

                            <a href="<?php the_permalink(); ?>">
                                <div class="tab-content-box">
                                    <img src="<?php echo esc_url($img_src_one); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
                                    <p><?php the_title(); ?></p>
                                </div>
                            </a>
                            <br>
                            <?php }
                                endwhile;
                                wp_reset_postdata();
                                }
                            ?>
                           
                           
                        </div>
                    </div>
                    <!--Start Second Column Query-->
                    <?php 
                    $col_two_args = array(
                        'post_type'       => 'post',
                        'posts_per_page'  => 5,
                        'post_status'     => 'publish',
                        'order'           => 'DESC',
                        'no_found_rows'   => true,
                    );
                    if ( ! empty( $section_cat_slug_two ) ) {
                        $col_two_args['category_name'] = sanitize_title( $section_cat_slug_two );
                    }
                    
                    $col_two_query = new WP_Query( $col_two_args );
                    if($col_two_query->have_posts()){
                    $sl_two = 0;  
                    ?>
                    <div class="col-md-4">
                        <div class="jation-rajneti-title">
                          <a href="<?php echo esc_url( home_url( '/category/' . $section_cat_slug_two ) ); ?>"><h2><?php echo esc_html($section_title_two);?></h2></a>
                           <?php 
                                while($col_two_query->have_posts()): $col_two_query->the_post(); 
                                $sl_two = $sl_two+1;
                                $post_id_two = get_the_ID();
                                
                                $thumb_size_two = ( $sl_two == 1 ) ? 'khulna_gazette_lead_thumb' : 'khulna_gazette_post_thumb';
                                $img_src_two = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_two, $thumb_size_two ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
                                $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                            ?>
                            
                            <?php if($sl_two==1){ ?>
                            <a href="<?php the_permalink(); ?>" class="kg-lead-link">
                                <div class="kg-lead-thumb-wrap">
                                    <img src="<?php echo esc_url($img_src_two); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async" class="kg-lead-img">
                                </div>
                                <h4><?php the_title(); ?></h4>
                            </a>
                            <?php }
        
                            else{
                            ?>
                            

                            <a href="<?php the_permalink(); ?>">
                                <div class="tab-content-box">
                                    <img src="<?php echo esc_url($img_src_two); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
                                    <p><?php the_title();?></p>
                                </div>
                            </a>
                            <br>
                            <?php }
                                endwhile;
                                wp_reset_postdata();
                                }
                            ?>
                           
                           
                        </div>
                    </div>
                    <!--End column two-->
                    
                    <?php 
                    $col_three_args = array(
                        'post_type'       => 'post',
                        'posts_per_page'  => 5,
                        'post_status'     => 'publish',
                        'order'           => 'DESC',
                        'no_found_rows'   => true,
                    );
                    if ( ! empty( $section_cat_slug_three ) ) {
                        $col_three_args['category_name'] = sanitize_title( $section_cat_slug_three );
                    }
                    
                    $col_three_query = new WP_Query( $col_three_args );
                    if($col_three_query->have_posts()){
                    $sl_three = 0;  
                    ?>
                    <div class="col-md-4">
                        <div class="jation-rajneti-title">
                          <a href="<?php echo esc_url( home_url( '/category/' . $section_cat_slug_three ) ); ?>"><h2><?php echo esc_html($section_title_three);?></h2></a>
                           <?php 
                                while($col_three_query->have_posts()): $col_three_query->the_post(); 
                                $sl_three = $sl_three+1;
                                $post_id_three = get_the_ID();
                                
                                $thumb_size_three = ( $sl_three == 1 ) ? 'khulna_gazette_lead_thumb' : 'khulna_gazette_post_thumb';
                                $img_src_three = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_three, $thumb_size_three ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
                                $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                            ?>
                            
                            <?php if($sl_three==1){ ?>
                            <a href="<?php the_permalink(); ?>" class="kg-lead-link">
                                <div class="kg-lead-thumb-wrap">
                                    <img src="<?php echo esc_url($img_src_three); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async" class="kg-lead-img">
                                </div>
                                <h4><?php the_title(); ?></h4>
                            </a>
                            <?php }
        
                            else{
                            ?>
                            

                            <a href="<?php the_permalink(); ?>">
                                <div class="tab-content-box">
                                    <img src="<?php echo esc_url($img_src_three); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
                                    <p><?php the_title();?></p>
                                </div>
                            </a>
                            <br>
                            <?php }
                                endwhile;
                                wp_reset_postdata();
                                }
                            ?>
                           
                           
                        </div>
                    </div>
                </div>
                


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
