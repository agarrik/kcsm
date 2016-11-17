<?php        
        
  /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $type
 * @var $photo
 * @var $video
 * @var $link
 * @var $circle_shape
 * Shortcode class
 * @var  WPBakeryShortCode_Services_Media
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
  

        $output = '<div class="wpb_content_element services_media">';

     
       if($circle_shape == 'yes'){
        $photo_size = array(200, 200);
        $photo_class="port_quadratic";
       }else{
        $photo_size = 'port3';   
        $photo_class='port3';
       }
        
        if($type == 'img'){
            if(!empty($photo)) {
            
                if(strpos($photo, "http://") !== false){
                    $photo = $photo;
                } else {
                   
                    $bg_image_src = wp_get_attachment_image_src($photo, $photo_size);
                    $photo = $bg_image_src[0];
                }
            }
            $output .= '<div class="img_div '.$photo_class.'">';
             if($link != '#' && $link != '')
            $output .= '<a href="'.$link.'" target="_blank"><img src="'.$photo.'" alt="" /></a>';
            else
                $output .= '<img src="'.$photo.'" alt="" />';
            $output .= '</div>';
        }
	   
	    else
        if($type == 'video'){
            if(isset($video)){
                global $wp_embed;
                $output .= $wp_embed->run_shortcode('[embed]'.trim($video).'[/embed]');
            }
        }
        if($link != '#' && $link != ''){
        $output .= '<h1><a href="'.$link.'">'.$title.'</a></h1>';
        }
        else{
            $output .= '<h1>'.$title.'</h1>';
        }
        $output .= '<div class="serv_content">';
           
            $output .= '<p>'.do_shortcode($content).'</p>';

        $output .= '</div>';

        /*$output .='<span class="read_more"><a href="'.$link.'">'.__('Learn More', 'themeple').'</a></span>';*/
        $output .= '</div>';
        echo $output;
?>