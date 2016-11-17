<?php        

  /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $link
 * @var $icon_bool
 * @var $icon
 * @var $color
 * Shortcode class
 * @var  WPBakeryShortCode_Services_Box_Color
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
  

        if ($color != '')

            $style = 'background:'.$color;

        $output = '<div class=" services_box_color wpb_content_element '.$style.'">';

        if($icon_bool == 'yes')

            $output .= '<div class="icon"><i class="'.$icon.'"></i></div>';

        $output .= '<div class="title"><a href="'.$link.'">'.$title.'</a></div>';

        $output .= '</div>';

        echo $output;

?>