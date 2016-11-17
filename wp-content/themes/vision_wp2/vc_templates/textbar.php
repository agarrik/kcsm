<?php

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $subtitle
 * @var $button1_title
 * @var $button_color
 * @var $button1_link
 * @var $button_style
 * @var $font_color
 * @var $background_color
 * @var $top_border
 * @var $extra_class
 * Shortcode class
 * @var  WPBakeryShortCode_Textbar
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );		


        if($top_border == 'no')

            $border_remover = 'border:none;';
        else $border_remover="";

        $output = '<div class="textbar-container wpb_content_element '.$extra_class.' style_1 " style="background:'.$background_color.'; '.$border_remover.';">';

            

                $output .= '<h1 style="color: '.$font_color.'">'.do_shortcode($title).'</h1>';
                $output .='<span class="subtitle" style="color: '.$font_color.'">'.$subtitle.'</span>';

                if(isset($button1_title) && $button1_title != '')

                    $output .= '<a href="'.$button1_link.'" class="btn-system normal '.$button_style.'" style=" border:0px; color:#fff; background:'.$button_color.';">'.$button1_title.'</a>';


            

        $output .= '</div>';

        echo $output;



?>