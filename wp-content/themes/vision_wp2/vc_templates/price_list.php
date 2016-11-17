<?php
 /**
 * Shortcode attributes
 * @var $atts
 * @var $dynamic_title
 * @var $dynamic_src
 * @var $title
 * @var $title_color
 * @var $price
 * @var $price_color
 * @var $currency
 * @var $period
 * @var $period_color
 * @var $button_title
 * @var $button_link
 * @var $first_color
 * @var $highlight_table
 * @var $dynamic_size
 * Shortcode class
 * @var  WPBakeryShortCode_Price_List
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
    

    $output = '<div class="wpb_content_element">';  

        if(!empty($dynamic_title)){

            $output .= '<div class="header"><h3>'.$dynamic_title.'</h3></div>';

        }

        $extra_class='';

        $position = 'relative';

       

       $output = "";

        $output .= '<div class="span'.$dynamic_size.'">';
        
        
         if(empty($first_color) or empty($second_color)){

            $first_color = themeple_get_option('base_color');
            $second_color = themeple_get_option('second_color');

         }

         $style_1 = '';
         $style_2 = '';

         if($highlight_table == 'yes'){
              $title_color  = ($title_color == '' ? $title_color = "#fff" : $title_color ) ;
              $price_color = ($price_color == '' ? $price_color ="#fff" :  $price_color) ;

               $style_1 ="background:$first_color; color:$title_color !important; border-bottom:none;";
               $style_2 ="background:$second_color; color:$price_color !important";

         }
       

            $output .='<div class="price_box" >';

              $output .= '<div class="title" style="'.$style_1.'">';

                $output .= $title;

              $output .=  '</div>';   

            $output .='<div class="price " style="'.$style_2.'">';
                  
            $output .= '<span class="p">'.$currency.$price. '</span><span class="period" style="color:'.$period_color.'">'.$period.'</span>';

            $output .= '</div>';

            $output .='<ul>';

                  $output .= "\n\t\t\t\t".wpb_js_remove_wpautop($content);

            $output .='</ul>';

           $output .= '<div class="footer">'; 
              
                $output .= '<a href="'.$button_link.'" class="btn-system only_border" style="border-radius:5px; border:1px solid '.$first_color.' ">'.$button_title.'</a>';

          

           $output .= '</div>';

           $output .= '</div>';

           $output .= '</div>';

          

           echo $output;


?>