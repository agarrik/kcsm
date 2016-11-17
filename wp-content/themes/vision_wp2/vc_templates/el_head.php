<?php
		
	/**
 * Shortcode attributes
 * @var $atts
 * @var $dynamic_title
 * Shortcode class
 * @var $this WPBakeryShortCode_El_Head
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
	

        $output = '';
	    if(!empty($dynamic_title)){
            $extra_style = '';
            $extra_class = '';
            
            $output = '<div class="header '.$extra_class.'" style="'.$extra_style.'"><h2>'.$dynamic_title.'</h2>';
            
         
            $output .= '</div>';
        }
        echo $output; 


?>