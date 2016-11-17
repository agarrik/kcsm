<?php
	
 /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $icon
 * Shortcode class
 * @var  WPBakeryShortCode_List_Item
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

        $output = '<dl class="dl-horizontal list">';
        	$output .= '<dt><div class="overlay"></div><div class="circle"><i class="'.$icon.'"></i></div></dt>';
        	$output .= '<dd>';
        		$output .= '<h4>'.$title.'</h4>';
        		$output .= '<p>'.wpb_js_remove_wpautop($content).'</p>';
        	$output .= '</dd>';
        $output .= '</dl>';

        echo $output;

?>