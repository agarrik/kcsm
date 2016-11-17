<?php        

   /**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $icon_bool
 * @var $icon
 * @var $button
 * @var $dynamic_content_type
 * @var $style
 * @var $dynamic_post
 * @var $dynamic_page
 * @var $dynamic_content_link
 * Shortcode class
 * @var  WPBakeryShortCode_Services_Boxed
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
 

        $output = '<div class=" services_boxed wpb_content_element '.$style.'">';

        $icon_class = (($icon_bool == 'yes')?'with_icon':'no_icon');

        $data = array();

        $query = array();

        $data['link'] = '';

        $data['description'] = '';

        if($dynamic_content_type == 'page'){

            $query = array( 'p' => $dynamic_page, 'posts_per_page'=>1, 'post_type'=> 'page' );

        }

        if($dynamic_content_type == 'post'){

            $query = array( 'p' => $dynamic_post, 'posts_per_page'=>1, 'post_type'=> 'post' );

        }

        if($dynamic_content_type == 'content'){

            $data['description'] = $content;

            $data['link'] = $dynamic_content_link;

        }else{

            $loop = new WP_Query($query);

            if($loop->have_posts()){

                while($loop->have_posts()){

                    $loop->the_post();

                    

                    $data['link'] = get_permalink();

                    $data['description'] = get_the_excerpt();

                    

                }

            }

            wp_reset_postdata();

        }



        

            

            if($icon_bool == 'yes' && !empty($icon)):

               

                $output .= '<div class="icon_wrapper">';


                $output .= '<div class="overlay"></div>';

                $output .= '<i class="'.$icon.'"></i></div>';

                



            endif;



        $output .= '<h4><a href="'.$data['link'].'">'.$title.'</a></h4>';
        $output .= '<div class="line_under"><div class="line_center"></div></div>';

        $output .= '<p>'.do_shortcode($data['description']).'</p>';

        if(!empty($button)):
        $output .= '<span><a href="'.$data['link'].'">'.$button.'</a></span>';
        endif;

        $output .= '</div>';

        echo $output;

?>