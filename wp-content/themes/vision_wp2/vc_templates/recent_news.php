<?php
        
    /**
 * Shortcode attributes
 * @var $atts
 * @var $posts_per_page
 * @var $dynamic_from_where
 * @var $dynamic_cat
 * @var $dynamic_title
 * @var $posts_number
 * @var $style
 * @var $extra_class
 * Shortcode class
 * @var  WPBakeryShortCode_Recent_News
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


        if($style == 'style_2'):

            $extra_class = 'style_2'; 

        endif;    

        $output = '<div class="recent_news wpb_content_element">';
      
            if(!empty($dynamic_title))
            $output .= '<div class="header"><h2>'.$dynamic_title.'</h2></div>';
      
            $output .= '<div class="pagination news"><a href="#" class="prev"></a><a href="#" class="next"></a></div>';
        
        if($dynamic_from_where == 'all_cat'){
            $query_post = array('posts_per_page'=> $posts_number, 'post_type'=> 'post' );                          
        }else{
           $query_post = array('posts_per_page'=> $posts_number, 'post_type'=> 'post', 'cat' => $dynamic_cat ); 
        }
        

            $output .= '<div class="row">';
                $output .= '<div class="news-carousel '.$extra_class.'">';
                $i = 0;   
                       
                        $loop = new WP_Query($query_post);
                                    
                                     if($loop->have_posts()){
                                        while($loop->have_posts()){
                                            $loop->the_post();     
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

                                $count = 0;

                                $comment_entries = get_comments(array( 'type'=> 'comment', 'post_id' => get_the_ID() ));

                                if(count($comment_entries) > 0){

                                    foreach($comment_entries as $comment){

                                        if($comment->comment_approved)

                                            $count++;

                                    }

                                }
                                if($style == 'style_2'){

                                    $output .= '<div class="news-carousel-item">';
                             
 
                                               $output .= '<dl class="news-article blog-article dl-horizontal style_2">';
                                                    
                                                    $output .= '<dd>';
                                                        
                                                        $output .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
                                                         $output .= '<div class="tags"><i class="linecon-icon-user"></i> <span>On '. get_the_date() .'</span>
                                                         &nbsp;&nbsp;&nbsp;<i class="linecon-icon-bubble"></i> <span> '.esc_attr($count) .' '.  __("Comments", "themeple").'</span></div>';

                                                       // $output .= '<div class="tags">'.__('by', 'themeple').' '.get_the_author().' | '.$count.' '.__('Comments', 'themeple').'</div>';

                                                        $output .= '<div class="blog-content">';        
                                                        
                                                        $output .=      themeple_text_limit(get_the_excerpt(), 30);

                                                        //$output .= '<div class="read_right"><a href="'.get_permalink().'">'.__('Read More', 'themeple').'</a></div>';
         
                                                        $output .= '</div>'; 
                                                    $output .= '</dd>';
                                               $output .= '</dl>'; 

                                    $output .='</div>';  

                                } else {

                                  
                                    $output .= '<div class="news-carousel-item">';
                                           

                                               $output .= '<dl class="news-article blog-article dl-horizontal">';
                                                    $output .= '<dt>';

                                                 
                                                        $output .= '<img src="'.themeple_image_by_id(get_post_thumbnail_id(), 'recent_news', 'url').'" alt="">';
                                            
                                                      
                                                    
                                                    $output .= '</dt>';   
                                                    $output .= '<dd>';
                                                        
                                                        $output .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';

                                                       $output .= '<div class="tags"><i class="linecon-icon-user"></i> <span>On '. get_the_date() .'</span>
                                                         &nbsp;&nbsp; &nbsp;<i class="linecon-icon-bubble"></i> <span> '.esc_attr($count) .' '.  __("Comments", "themeple").'</span></div>';

                                                        $output .= '<div class="blog-content">';        
                                                        
                                                        $output .=      themeple_text_limit(get_the_excerpt(), 20);
         
                                                        $output .= '</div>'; 

                                                        //$output .= '<div class="read_more"><a href="'.get_permalink().'">'.__('Read More', 'themeple').'</a></div>';

                                                    $output .= '</dd>';
                                               $output .= '</dl>'; 

                                     $output .= '</div>';         
                                                     
                                  
                              

                                            }
                                            
                                        };
                                    };
                         
                                    wp_reset_query(); 
                                   
                    $output .= '</div>';       
            $output .= '</div>';
        $output .= '</div>';


        echo $output;
        
?>