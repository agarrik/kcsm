<?php 
    if(themeple_post_meta(themeple_get_post_id(), 'page_header_bool') != 'no'): 

        $extra_class = $extra_style = '';

		$style = themeple_post_meta(themeple_get_post_id(), 'page_header_style');

        if($style == '')
            $style = 'basic';

		$title = get_the_title(themeple_get_post_id());

		$page_parents = themeple_page_parents();

		$extra_class .= $style;

		$icon = themeple_post_meta(themeple_get_post_id(), 'page_header_icon');

		$subtitle = themeple_post_meta(themeple_get_post_id(), 'second_title');

		$page_header_basic_bg_color = themeple_post_meta(themeple_get_post_id(), 'page_header_basic_bg_color');

        $page_header_centered_overlay_bg_color = themeple_post_meta(themeple_get_post_id(), 'page_header_centered_overlay_bg_color');
        
        if($style ==  'basic'){

            $extra_style .= 'background-image:url('.esc_url(themeple_post_meta(themeple_get_post_id(), 'background_image')).');background-repeat: no-repeat;';

            $extra_class .= ' background_image';

        }

        if($style == 'basic' && (themeple_post_meta(themeple_get_post_id(), 'background_image') == '' )){

        	$extra_style .= 'background:'.$page_header_basic_bg_color.';';

        	 $extra_class .= ' colored_bg';

        }

		if(themeple_post_meta(themeple_get_post_id(), 'background_image') != '' && themeple_post_meta(themeple_get_post_id(), 'header_type') == 'image' || themeple_post_meta(themeple_get_post_id(), 'page_header_style') == 'left'){

            $extra_style .= 'background-image:url('.esc_url(themeple_post_meta(themeple_get_post_id(), 'background_image')).');background-repeat: no-repeat;';

            $extra_class .= ' background_image';

        }

        if(themeple_post_meta(themeple_get_post_id(), 'color_pick') != '' && themeple_post_meta(themeple_get_post_id(), 'header_type') == 'color'){

            $extra_class .= ' colored_bg';

            $extra_style .= ' background-color:'.esc_attr(themeple_post_meta(themeple_get_post_id(), 'color_pick')).';';

        }
 
        $centered = themeple_post_meta(themeple_get_post_id(), 'centered');

        if(isset($centered) && $centered == 'centered'){

            $extra_style .= ' background-position:center;';

        }else{

            $extra_style .= '   background-position: center bottom; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';

        }
        $page_header_color = themeple_post_meta(themeple_get_post_id(), 'page_header_font_color');
        $extra_style .= ' color:'.$page_header_color.'; '; 
        $page_header_basic_font_color = themeple_post_meta(themeple_get_post_id(), 'page_header_basic_font_color');
        $second_title_left = themeple_post_meta(themeple_get_post_id(), 'second_title_left');
        $description_left =  themeple_post_meta(themeple_get_post_id(), 'description_left');
        $description_basic = themeple_post_meta(themeple_get_post_id(), 'description_basic');
        $page_header_parallax= themeple_post_meta(themeple_get_post_id(), 'page_header_parallax');

        if(themeple_post_meta(themeple_get_post_id(), 'header_type') == 'video_bg')
            $extra_class .= ' video_bg';

        if($page_header_parallax=='yes')
            $extra_class .= ' parallax';

        ?>

        

  
    <!-- Page Head -->

    <?php  ?>

   <div class="header_page <?php echo esc_attr($extra_class) ?>" style="<?php echo esc_attr($extra_style) ?>">


  
        <div class="bg_overlay" style="background-color:<?php echo $page_header_centered_overlay_bg_color ?>"></div>


            <?php if(themeple_post_meta(themeple_get_post_id(), 'header_type') == 'video_bg'): ?>
            <?php 
                $video_markup = '<div class="video-wrap">';
                    $video_markup .= '<video id="video_background" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0"> ';
                        $webm = themeple_post_meta(themeple_get_post_id(), 'video_webm');
                        $mp4 = themeple_post_meta(themeple_get_post_id(), 'video_mp4');
                        if(!empty($webm))
                            $video_markup .= '<source src="'.esc_url($webm).'" type="video/webm">'; 
                        
                        if(!empty($mp4))
                            $video_markup .= '<source src="'.esc_url($mp4).'" type="video/mp4">';

                        $video_markup .= 'Video not supported';
                    $video_markup .= '</video>';
                $video_markup .= '</div>';
                echo $video_markup;
            ?>
            <?php endif; ?>
            <div class="container">

               <?php if($style == 'left') : ?>

                        <div class="left_content">

                            <h2> <?php echo esc_attr($second_title_left); ?></h2>     
                            <div class="border_bottom_left"></div> 
                            <div class="description_left"><?php echo esc_attr($description_left); ?></div> 

                        </div>

                <?php endif; ?>    

              
                	<?php if($style == 'centered'): ?>

	                    <div class="centered_content ">
	                    <?php $page_header_font_color = themeple_post_meta(themeple_get_post_id(), 'page_header_font_color');
                        $page_header_title_font_color = themeple_post_meta(themeple_get_post_id(), 'page_header_title_font_color');
                        $first_title = themeple_post_meta(themeple_get_post_id(), 'first_title');
                         $page_hader_description= themeple_post_meta(themeple_get_post_id(), 'page_hader_description');  ?> 
	                    <h2  style="color:<?php echo esc_attr($page_header_title_font_color) ?>;"><?php echo esc_attr($first_title) ?></h2>
                        <div class="line_under"><div class="line_center"></div></div>
	                    <p  style="color:<?php echo esc_attr($page_header_font_color); ?>"><?php echo esc_attr($page_hader_description) ?></p>   

	                <?php endif; ?>    


                 <?php if($style == 'basic') : 

                   $page_parents = themeple_page_parents();
                   $page_header_basic_breadcrumbs_size = themeple_post_meta(themeple_get_post_id(), 'page_header_basic_breadcrumbs_size');
                   $page_header_basic_title_size =themeple_post_meta(themeple_get_post_id(), 'page_header_basic_title_size');
                   $page_header_basic_font_color = themeple_post_meta(themeple_get_post_id(), 'page_header_basic_font_color');

                 ?>
                    <style>
                    .breadcrumbs_c {color:<?php echo esc_attr($page_header_basic_font_color) ?>; font-size:<?php echo esc_attr($page_header_basic_breadcrumbs_size); ?>; }
                    h1.title {color:<?php echo esc_attr($page_header_basic_font_color); ?> !important; font-size: <?php echo esc_attr($page_header_basic_title_size); ?>}
                    </style>
                    <h1 class="title"><?php echo esc_attr($title) ?></h1>
                    <div class="breadcrumbss">
                        
                        <ul class="page_parents pull-right">
                           
                            <li class="breadcrumbs_c" ><a class="breadcrumbs_c" href="<?php echo home_url() ?>">Home</a></li>
                            
                            <?php for($i = count($page_parents) - 1; $i >= 0; $i-- ){ ?>

                            <li class="breadcrumbs_c"><a class="breadcrumbs_c" href="<?php echo get_permalink($page_parents[$i]) ?>"><?php echo get_the_title($page_parents[$i]) ?> </a></li>

                            <?php }  ?>
                            
                            <li class="breadcrumbs_c" ><a class="breadcrumbs_c" href="<?php echo get_permalink() ?>"><?php echo esc_attr($title) ?></a></li>

                        </ul>
                    </div>
                    
                <?php endif; ?> 


                <?php if($style == 'centered'): ?>
                </div>
                <?php endif; ?>

                  


            </div>

            

    </div> 

   

    

    <?php endif; ?>