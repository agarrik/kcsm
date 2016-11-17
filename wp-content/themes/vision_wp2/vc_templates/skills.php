<?php
		
		/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $desc
 * Shortcode class
 * @var  WPBakeryShortCode_Skills
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
       

		$output = '<div class="wpb_content_element block_skill">';

        $output .= "\n\t\t\t\t".wpb_js_remove_wpautop($content);

        $output .= '</div>';
        echo  $output;


?>