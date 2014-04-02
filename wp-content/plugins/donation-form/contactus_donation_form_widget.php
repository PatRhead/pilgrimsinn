<?php
/*
  The Donation Form Plugin by ContactUs.com.
 */

//Contact Subscribe Box widget extend 

class contactus_donation_form_Widget extends WP_Widget {

	function contactus_donation_form_Widget() {
		$widget_ops = array( 
			'description' => __('Displays Donation Form by ContactUs.com', 'contactus_form')
		);
		$this->WP_Widget('contactus_donation_form_Widget', __('Donation Form by ContactUs.com', 'contactus_form'), $widget_ops);
	}

	function widget( $args, $instance ) {
		if (!is_array($instance)) {
			$instance = array();
		}
		contactuscom_donation_form(array_merge($args, $instance));
	}
}

function contactuscom_donation_form($args = array()) {
    extract($args);
    $cUsDF_form_key = get_option('cUsDF_settings_form_key'); //get the saved form key
    
    if(strlen($cUsDF_form_key)){
        $xHTML  = '<div id="cUsDF_form_widget" style="clear:both;min-height:530px;margin:10px auto;">';
        $xHTML .= '<script type="text/javascript" src="//cdn.contactus.com/cdn/forms/'. $cUsDF_form_key .'/inline.js"></script>';
        $xHTML .= '</div>';
        
        echo $xHTML;
    }
}