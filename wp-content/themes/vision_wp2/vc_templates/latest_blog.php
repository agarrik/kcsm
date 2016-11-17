<?php 

   /**
 * Shortcode attributes
 * @var $atts
 * @var $dynamic_from_where
 * @var $post_selected
 * Shortcode class
 * @var  WPBakeryShortCode_Latest_blog
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
       

        $output = '<div class="latest_blog wpb_content_element">';

     
           query_posts('p= '.$post_selected); 

        

            $size_span_class = '';
           
            $output .= '<div class="blog_posts">';

                $output .= '<div class="posts">';   

                                                

                while (have_posts()) : the_post();

                          $post_id = get_the_ID();      
                                                $post_format = get_post_format($post_id);
                                                $i++;
                                                if(strlen($post_format) == 0)
                                                    $post_format = 'standart';
                              if($post_format == 'standart'){
                                $icon_class="pencil";
                                }elseif($post_format == 'audio'){
                                    $icon_class="music";
                                }elseif($post_format == 'soundcloud'){
                                    $icon_class="music";
                                }elseif($post_format == 'video'){
                                    $icon_class="play-circle";
                                }elseif($post_format == 'quote'){
                                    $icon_class="quotes-left";
                                }elseif($post_format == 'gallery'){
                                    $icon_class="images";
                                }
                        
                        if($post_format == 'standart' && get_post_thumbnail_id()){

                            $output .= '<div class="blog-article grid" >';
                            $output .= '<div class="he-wrap">';
                            
                            $output .='<div class="overlay ">
                                                <div class="bg a0" data-animate="fadeIn">
                                                    <div class="center-bar v1">
                                                        <div class="centered"> ';
                                                          $output .= '<a class="readmore" href="'.get_permalink().'">'.__('Read More', 'themeple').'</a>';
                                                               
                                                        $output .='</div>    
                                                          
                                                     </div>
                                                </div>
                                                 
                                            </div>';
                                            $output .='<img alt="image_blog" src="'.themeple_image_by_id(get_post_thumbnail_id(), 'port2', 'url').'">';
                            $output .= '</div>';
                            
                           
                                    
                            $output .= '<div class="blog_content">';      
                            
                         

                                 
                                            
                                            $output .= '<div class="content">';

                                                $output .= '<h5><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
                                                $output .= '<div class="tags"><i class="linecon-icon-user"></i> <span>On '. get_the_date() .'</span>
                                                         &nbsp;&nbsp; &nbsp;<i class="linecon-icon-bubble"></i> <span> '.esc_attr($count) .' '.  __("Comments", "themeple").'</span></div>';
                                                $output .= '<p>'.themeple_text_limit(get_the_excerpt(), 30).'</p>';
                                                

                                            $output .= '</div>';
  

                                    $output .= '</div>';  


                             $output .= '</div>';         
                        }
                    
                
                endwhile;
                wp_reset_query();
      
                $output .= '</div>';    
            $output .= '</div>';
        $output .= '</div>';
        echo $output;

?>