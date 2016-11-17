<?php

		

		extract(shortcode_atts(array(

            'dynamic_title' => '',

            'dynamic_src' => '',

            'height' => '',

            'desc' => '',

            'map_style' => ''

        ), $atts)); 

		$output = '<div class="wpb_content_element map-'.$map_style.'">';  

        if(!empty($dynamic_title)){

            $output .= '<div class="header"><h2>'.$dynamic_title.'</h2></div>';

        }

        $extra_class='';

        $position = 'relative';

       

        $output .= '<div class="row-fluid row-google-map " style="position:'.$position.'; height:'.$height.'px;"><iframe class="googlemap '.$extra_class.'" style="height:'.$height.'px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$dynamic_src.'"></iframe><div class="desc">'.$desc.'</div>';

         

        $output .= '</div>';

        

        $output .= '</div>';

        echo  $output;



?>