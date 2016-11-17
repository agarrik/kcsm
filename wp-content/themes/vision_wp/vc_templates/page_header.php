<?php



		extract(shortcode_atts(array(

            'title' => '',

            'subtitle' => '',

            'icon' => '',

            'size_title' => '',

            'size_icon' => '',

            'style' => '',

            'title_color' => '',

            'sub_title_color' =>'',
            
            'sub_title' =>''


        ), $atts)); 



        $output = '<div class="wpb_content_element dynamic_page_header '.$style.'">';

        if(!empty($sub_title)){
            
            $output .= '<h4 style=" color:'.$sub_title_color.'">'.$sub_title.'</h4>';
        }
       
        if(!empty($title)){
            
            $output .= '<h1 style="font-size:'.$size_title.'px; color:'.$title_color.'">'.$title.'</h1>';
        }

         if($style == 'style_1'){
          $output .='<div class="line_under"><div class="line_center"></div></div>';
            $output .='<p class="description">'.do_shortcode($content).'</p>';
            
           
        } elseif($style == 'style_2' || $style == 'style_3') {

           if(!empty($content)){
           $output .='<div class="line_under"><div class="line_left"></div></div>';
           }
           
           $output .= '<div class="description '.$style.'">'.do_shortcode($content).'</div>'; 



        }
                   
           

        $output .= '</div>';

        echo  $output;



?>