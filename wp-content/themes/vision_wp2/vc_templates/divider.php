<?php
	
/**
 * Shortcode attributes
 * @var $atts
 * @var $style
 * @var $margin_top
 * Shortcode class
 * @var $this WPBakeryShortCode_Creative_Tab
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

	
	if(!isset($style))
            $style = 'solid_border';
    if(!empty($margin_top))
    			$new ="style='margin-top:". $margin_top."'";    
        $output = '<div '.$new.' class="divider__ '.$style.'"></div>';

    echo $output;

?>