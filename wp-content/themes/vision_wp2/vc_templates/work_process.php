<?php
 /**
 * Shortcode attributes
 * @var $atts
 * @var $header
 * @var $text
 * @var $icon_1
 * @var $icon_2
 * @var $icon_3
 * @var $icon_4
 * @var $icon_5
 * Shortcode class
 * @var  WPBakeryShortCode_Work_Process
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


    $output = '<div class="work_process wpb_content_element">';

    	$output .= '<h1 class="big_title_element">'.$header.'</h1><p>'.$text.'</p>';
    	$output .= '<div class="process_block first">';
	    	$output .= '<div class="icon_1 process"><i class="'.$icon_1.'"></i><span class="little_circle"><span></span></span></div>';
	    	$output .= '<div class="icon_2 process"><i class="'.$icon_2.'"></i><span class="little_circle"><span></span></span></div>';
	    	$output .= '<div class="icon_3 process"><i class="'.$icon_3.'"></i><span class="little_circle"><span></span></span></div>';
    	$output .= '</div>';
    	$output .= '<div class="border_wrapper"></div>';
    	$output .= '<div class="process_block second">';
	    	$output .= '<div class="icon_4 process"><i class="'.$icon_4.'"></i><span class="little_circle"><span></span></span></div>';
	    	$output .= '<div class="icon_5 process"><i class="'.$icon_5.'"></i><span class="little_circle"><span></span></span></div>';
    	$output .= '</div>';
    $output .= '</div>';

    echo $output;
?>