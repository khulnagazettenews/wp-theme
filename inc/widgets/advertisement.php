<?php
add_action( 'widgets_init', 'scholarship_register_call_to_action_widget' );

function scholarship_register_call_to_action_widget() {
    register_widget( 'Scholarship_Call_To_Action' );
}

class Scholarship_Call_To_Action extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'scholarship_call_to_action',
            'description' => __( 'Khulnagazette home advertisement.', 'khulnagazette' )
        );
        parent::__construct( 'scholarship_call_to_action', __( 'KG: Advertisement', 'khulnagazette' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'section_bg_image' => array(
                'scholarship_widgets_name' => 'section_bg_image',
                'scholarship_widgets_title' => __( 'Advertisement Image', 'khulnagazette' ),
                'scholarship_widgets_field_type' => 'upload',
            ),

            'section_btn_url' => array(
                'scholarship_widgets_name'         => 'section_btn_url',
                'scholarship_widgets_title'        => __( 'Section Button Url', 'khulnagazette' ),
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

        $scholarship_section_bg_image   = empty( $instance['section_bg_image'] ) ? '' : $instance['section_bg_image'];

        $scholarship_section_btn_url    = empty( $instance['section_btn_url'] ) ? '' : $instance['section_btn_url'];

        echo $before_widget;
    ?>
            
               <section class="empty-30"></section>
               
               <div class="row">
                    <div class="col-md-12">
						<a href="<?php echo $scholarship_section_btn_url; ?>" target="_blank">
						   <div class="khulna-gazette-advertisement">
							  <img src="<?php echo $scholarship_section_bg_image; ?>">

						   </div>
						</a>
                        
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