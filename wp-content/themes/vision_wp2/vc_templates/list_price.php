<?php

	 /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * Shortcode class
 * @var  WPBakeryShortCode_List_Price
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );




        $output = '<ul class="dl-horizontal">';

        	

        	$output .= '<li>';

        		$output .= '<h4>'.$title.'</h4>';

        	

        	$output .= '</li>';

        $output .= '</ul>';



        echo $output;



?>