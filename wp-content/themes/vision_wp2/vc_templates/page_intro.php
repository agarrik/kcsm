<?php

 /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $position
 * @var $img_bool
 * @var $image
 * Shortcode class
 * @var  WPBakeryShortCode_Page_Intro
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


        if(!isset($img_bool)){
            $img_bool = 'no';
        }
        $output = '<div class="wpb_content_element page_intro type-'.$position.' img-'.$img_bool.' ">';
            if($img_bool == 'yes'){
                $output .= '<span class="img" style="background-image:url('.$image.');"></span>';
            }
            $output .= '<h1>'.do_shortcode($title).'</h1>';
        $output .= '</div>';
        echo $output;

?>