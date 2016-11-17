<?php

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $icon_number
 * @var $id
 * @var $icon
  * @var $number
 * Shortcode class
 * @var $this WPBakeryShortCode_Creative_Tab
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

	$u = $id;
	$output .= '<div class="pane '.(($u == 1)?'active':'').'" data-id="t'.$u.'">';
    $output .= wpb_js_remove_wpautop($content); 
    $output .= '</div>';
	echo $output;

?>