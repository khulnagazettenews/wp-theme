<?php


add_action( 'widgets_init', 'Khulnagazette_facebook_video_widget' );

function Khulnagazette_facebook_video_widget() {
    register_widget( 'Khulnagazette_facebook_video' );
}

class Khulnagazette_facebook_video extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'Khulnagazette_facebook_video',
            'description' => __( 'One column news section', 'khulnagazette' )
        );
        parent::__construct( 'Khulnagazette_facebook_video', __( 'KG: Facebook Video', 'khulnagazette' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'facebook_video_widget_title' => array(
                'scholarship_widgets_name'         => 'facebook_video_widget_title',
                'scholarship_widgets_title'        => __( 'Title', 'khulnagazette' ),
                'scholarship_widgets_field_type'   => 'text'
            ),
            
            'facebook_video_link' => array(
                'scholarship_widgets_name'         => 'facebook_video_link',
                'scholarship_widgets_title'        => __( 'Facebook Video', 'khulnagazette' ),
                'scholarship_widgets_field_type'   => 'text'
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

        $facebook_video_link = empty( $instance['facebook_video_link'] ) ? '' : $instance['facebook_video_link'];
        $facebook_video_widget_title = empty( $instance['facebook_video_widget_title'] ) ? '' : $instance['facebook_video_widget_title'];


        echo $before_widget;

    ?>
       <h2><?php echo $facebook_video_widget_title; ?></h2>
        <div class="fb-video" data-href="<?php echo esc_url($facebook_video_link); ?>" data-width="" data-allowfullscreen="true"></div>
    
                 
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
