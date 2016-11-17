<?php

 /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $testimon
 * @var $navigation
 * @var $style
 * Shortcode class
 * @var  WPBakeryShortCode_Single_Testimonial
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );		


		$output = ''; 

         if($style == 'normal' && !empty($title)){

            $output .= '<div class="header"><h2>'.$title.'</h2></div>';

        }

        $output .= '<div class="wpb_content_element full_testimonials '.$style.'">';

        

        if(!isset($testimon))

        $testimon = 0;          

        $query_post = array('posts_per_page'=> -1, 'post_type'=> 'testimonial' );                          

        $output .= '<div class="row">';


        if(!empty($title) && $style == 'full'){

       

            $output .= '<h2>'.$title.'</h2>';  

            $output .= '<div class="header style_3">';
            $output .= '</div>';   

          
        

        }

        $output .= '<div class="carousel carousel_single_testimonial">';   

                $loop = new WP_Query($query_post);

                             if($loop->have_posts()){



                                while($loop->have_posts()){

                                    

                                    $loop->the_post();  


                                    /*$post_id= get_the_ID();*/


                                    $output .= '<div class="single_testimonial ">';

                                    $output .= '<span class="img_testimonial">'.get_the_post_thumbnail($post->ID,  array(65,65)).'</span>';

                                    $output .= '<div class="content"><p>'.get_the_content().'</p><div class="data"><h4>'.get_the_title().'</h4> <h5> '.themeple_post_meta($post->ID, 'staff_position_').'</h5></div></div>';

                                    $output .= '</div>';



                               

                                            

                                }

                            }

      
        


        wp_reset_postdata();
        $output .= '</div>';
        $output .= '</div>';

        if(!empty($navigation) && $navigation == 'yes'){

            $output .= '<div class="controls"><a href="#" class="prev"></a><a href="#" class="next"></a></div>';
        }

        $output .= '</div>';
 


        echo $output;

?>