<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $link
 * @var $margin_top
 * @var $align
 * @var $bg_color
 * @var $this WPBakeryShortCode_Buttons
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$extra_class = '';


	$extra_class .= 'btn-system normal second_btn';
	

$styles="style='background-color: ".esc_attr($bg_color).";' ";
$output = '<div class="wpb_content_element custom_button align-'.esc_attr($align).' " style="margin-top:'.esc_attr($margin_top).'px;">';
    
    $output .= '<a class="btn-bt  '. esc_attr($extra_class).' " href="'.esc_url($link).'" '.$styles.'><span>'.esc_attr($title).'</span></a>';
    

$output .= '</div>';

echo  $output;

?>