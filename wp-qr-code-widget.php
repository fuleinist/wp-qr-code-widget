<?php
/*
Plugin Name: WP QR Code Widget
Plugin URI: N/A
Description: Create a dynamic QR code for this page url
Version: 1.0
Author: Fuleinist
Author URI: N/A
License: MIT
*/

class WP_QR_Code_Widget_Fuleinist extends WP_Widget {

	// constructor
	function WP_QR_Code_Widget_Fuleinist() {
		parent::WP_Widget(false, $name = __('QR Code Widget', 'WP_QR_Code_Widget_Fuleinist') );
	}

	// widget form creation
	function form($instance) {	
		// Check values 
		if( $instance ) { 
			$title    = esc_attr( $instance['title'] ); 
			$dynamic = esc_attr( $instance['dynamic'] );
			$url     = esc_attr( $instance['url'] );
			$size     = esc_attr( $instance['size'] );
		} else { 
			$title    = ''; 	
			$dynamic  = ''; 
			$url      = '';
			$size	  = '';
		}  ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'WP_QR_Code_Widget_Fuleinist' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'dynamic' ) ); ?>"><?php _e( 'Is Dynamic?', 'WP_QR_Code_Widget_Fuleinist' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'dynamic' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dynamic' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $dynamic ); ?> />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id('url') ); ?>"><?php _e( 'Url:', 'WP_QR_Code_Widget_Fuleiniste' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('url') ); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id('size') ); ?>"><?php _e( 'Size(px):', 'WP_QR_Code_Widget_Fuleinist' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('size') ); ?>" type="number" value="<?php echo $size; ?>" />
		</p>
		<?php 
	}

	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['dynamic'] = strip_tags($new_instance['dynamic']);
		  $instance['url'] = strip_tags($new_instance['url']);
		  $instance['size'] = strip_tags($new_instance['size']);
		 return $instance;
	}

	// widget display
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $title = apply_filters('widget_title', $instance['title']);
	   $dynamic = $instance['dynamic'];
	   $url = $instance['url'];
	   $size = $instance['size'];
	   echo $before_widget;
	   // Display the widget
	   echo '<div class="text-center">';
	   // Check if title is set
	   if ( $title ) {
		  echo $before_title . $title . $after_title;
	   }
	   if ( $size ) {
		   $chs = $size . 'x'. $size;
	   } else {
		   $chs = '500x500';
	   }
	   	foreach($_GET as $key => $value){
			$vars .= "&" . $key . "=" . $value;
		}
		if( $dynamic ) {
				echo '<img src="http://chart.apis.google.com/chart?chs='.$chs.'&cht=qr&chl='.esc_url( get_permalink() ).'?'.$vars.'"></img>';
			} else if ($url) {
				echo '<img src="http://chart.apis.google.com/chart?chs='.$chs.'&cht=qr&chl='.esc_url( $url ).'?'.$vars.'"></img>';
			} else {
				echo '<img src="http://chart.apis.google.com/chart?chs='.$chs.'&cht=qr&chl='.esc_url( get_permalink() ).'?'.$vars.'"></img>';
			}
	   // Check if textarea is set

	   echo '</div>';
	   echo $after_widget;
	}
}

// register widget

function fuleinist_register_widgets() { 
	register_widget( 'WP_QR_Code_Widget_fuleinist' );
}

add_action( 'widgets_init', 'fuleinist_register_widgets' );

?>
