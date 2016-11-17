<?php global $themeple_config; ?>

<!DOCTYPE html>

<html <?php language_attributes(); ?> class="css3transitions">
 
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <?php  if (function_exists('themeple_favicon'))    { echo themeple_favicon(esc_attr(themeple_get_option('favicon')) ); } ?>

    <!-- Title -->

    <title><?php wp_title('|', true, 'right'); ?></title>

    <!-- Responsive Meta -->
    <?php if(themeple_get_option('responsive_layout') == 'yes'): ?> <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> <?php endif; ?>

    <!-- Pingback URL -->
    <link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

	<!--[if lt IE 9]>

	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->

    <?php
    
    //Generated css from options
    include(THEMEPLE_BASE.'/template_inc/admin/register_styles.php'); 
    
    // Loaded all others styles and scripts.
   

    ?>

    <?php 
   
    

    wp_head();     
    
    ?>
</head>

<!-- End of Header -->



<body  <?php body_class(); ?>>

  <?php 
    // Google analytics
    $google_analytics = themeple_get_option('googlecode');
    echo esc_attr($google_analytics);

   ?>
<!-- Used for boxed layout -->
    <?php  
        $layout = themeple_get_option('overall_layout'); 
        if(( $layout == 'boxed' && !isset($_COOKIE['themeple_layout'])) || (isset($_COOKIE['themeple_layout']) && $_COOKIE['themeple_layout'] == 'boxed' )) { 
    ?>
<!-- Boxed Layout Wrapper -->
<div class="boxed_layout">

    <?php }  ?>
    

    <!-- Start Top Navigation -->
    <?php if( (themeple_get_option('top_widget') == 'yes' && !isset($_COOKIE['themeple_top_widget'])) || (isset($_COOKIE['themeple_top_widget']) && $_COOKIE['themeple_top_widget'] == 'yes') ): ?>
    <div class="top_nav">
        
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <div class="pull-left">
                        <?php dynamic_sidebar( "Top Header Left" ); ?>
                    </div>
                </div>
                <div class="span6">
                    <div class="pull-right">
                        <?php dynamic_sidebar( "Top Header Right" ); ?>
                    </div>
                </div>
               
            </div>
        </div>

    </div>
    <?php endif; ?>

    <!-- End of Top Navigation -->

    

    <!-- Page Background used for background images -->
    <div id="page-bg"><?php $bg_your_img = esc_attr(themeple_get_option('bg_your_img') ); if(isset($bg_your_img) && $bg_your_img != '' && ($bg_type=='fixed' || isset($_COOKIE['themeple_background']))) echo '<img src="'.$bg_your_img.'" alt="" />' ?></div>

    <?php $header_class = themeple_get_header_class();?>
    <?php $page_header_transparent = themeple_post_meta(themeple_get_post_id(), 'page_header_transparent'); 


   $top_wrapper_style = themeple_get_option('header_transparent');

    if( $top_wrapper_style=='yes' && $header_class=='header_1')
            
            $top_wrapper_style=' transparent';

        else 

            $top_wrapper_style=' no-transparent';


    ?>
    
    <?php $sticky_class = themeple_get_option('sticky_menu'); if($sticky_class == 'yes') $sticky_class = 'sticky_header'; else $sticky_class = '';  ?>
    <?php $one_page = themeple_post_meta(themeple_get_post_id(), 'one_page_bool_'); if($one_page == 'yes') $one_page = true; else $one_page = false; ?>
    <!-- Header BEGIN -->
      <?php if($header_class =='header_3' || (isset($_COOKIE['themeple_header']) && $_COOKIE['themeple_header']=='3'))
            $header_vertical = themeple_get_option('header_types_vertical');

        else
            $header_vertical="";?>
    <div class="viewport <?php   echo esc_attr($header_vertical) ?>">
    <!-- one page -->
    <?php if($one_page): ?>
    <?php get_template_part('template_inc/one_page_header'); ?>
    <?php endif; ?>

    <?php if(!$one_page): ?>
    <?php $header_type = themeple_get_option('header_types');
       
    ?>
   
 
    <div  class="header_wrapper <?php echo esc_attr($header_class.$top_wrapper_style)  ?> <?php echo esc_attr($header_vertical) ?> <?php echo ($type =='header_3' ? 'left_pos' : False)  ?> ">
        <header id="header" class="<?php 
        if($header_type !='header_3')
        echo esc_attr($sticky_class) 
        ?> ">



            <div class="container">
        	   <div class="row-fluid">
                    <div class="span12">
                       

                        <!-- Logo -->
                        <?php if(!isset($css_class)) $css_class=''; ?>
                        <div id="logo" class="<?php echo esc_attr($css_class) ?>">
                            <?php echo themeple_logo() ?>
                        </div>
                      
                        <!-- #logo END -->
    			         
                        <div class="after_logo"> 
                            

                                <!-- Search -->

                                <?php $right_search = esc_attr(themeple_get_option('right_search'));

                                    if($right_search == 'yes'): ?>

                                        <div class="header_search">
                                            <div class="right_search">
                                               <i class="moon-search-2"></i>
                                            </div>
                                            <div class="right_search_container"><?php get_search_form(); ?> </div> 
                                        </div>
                                    <?php endif; ?>
                                <!-- End Search-->
                        </div>        

                        
                        <!-- Show for all header expect header 4 -->


                                 <div id="navigation" class="nav_top pull-right  <?php echo esc_attr($css_class) ?>">
                                    <nav>
                                    <?php 
                                            $args = array("theme_location" => "main", "container" => false, "fallback_cb" => 'themeple_fallback_menu');
                                            wp_nav_menu($args);  
                                    ?>
                                    </nav>
                                </div><!-- #navigation -->
                                <!-- bottom widget area for vertical navigation-->
                                  <?php if( $header_vertical!=''){?>
                                        <div class="pull-left">
                                            <?php dynamic_sidebar( "Bottom Header - Vertical Widgetized" ); ?>
                                        </div>
                                  <?php }?>
    			        
                         <!-- End custom menu here -->
    		    	     <a href="#" class="mobile_small_menu open"></a>
                    </div>
                </div>

               
            </div>

             <?php if($sticky_class == 'yes'): ?>

             <div class="header_shadow"><span class="<?php echo esc_attr(themeple_get_option('header_shadow')); ?>"></span></div>
             
             <?php endif; ?>

        </header>
        <?php $social_icons = themeple_get_option('social_icons'); 

        // For online Purposes Only

         if(isset($_COOKIE['themeple_header']) && ($_COOKIE['themeple_header'] == '6' || $_COOKIE['themeple_header'] == '5'))  {

            $header_bar = 'yes';


         }else{

            $header_bar = themeple_get_option('header_bar'); 
         }
               
        $header_bar_left_text = themeple_get_option('header_bar_left_text');

        if($header_bar == "yes"): ?>
        <div class="header_bar">
            <div class="container">
                <div class="row-fluid">
                    <div class="span12">
                        <h3 class="pull-left"><?php echo esc_attr($header_bar_left_text); ?></h3>
                        <?php if(!empty($social_icons)): ?>
                        <ul class="pull-right socials">
                            
                            <?php foreach($social_icons as $s): ?>
                                <li><a href="<?php echo esc_url($s['link']) ?>"><i class="moon-<?php echo esc_attr($s['social']) ?>"></i></a></li>
                            <?php endforeach ?>
                        </ul>
                        <?php endif; ?>
                        <h3 style="float:right"><?php echo __('', 'themeple'); ?></h3>
                    </div>
                </div>
            </div>
         </div> 

        <?php endif; ?>
      
        <?php if(!(themeple_post_meta(themeple_get_post_id(), 'padding_slide') == 'yes' && themeple_post_meta(themeple_get_post_id(), 'section_or_no') == 'no') && themeple_get_option('header_shadow') != 'shadow_none' ): ?>
        <div class="header_shadow"><span class="<?php echo esc_attr(themeple_get_option('header_shadow')); ?>"></span></div>
        <?php endif; ?>
        <!-- Responsive Menu -->
        <?php get_template_part('template_inc/menu', 'small'); ?>
        <!-- End Responsive Menu -->
    </div>
    <?php endif; ?>
   
    <?php if($one_page) $top_cl = 'sect_top'; else $top_cl = ''; ?>
    <div class="top_wrapper <?php echo esc_attr($top_cl.' '.$top_wrapper_style) ?>" >
    <?php get_template_part('template_inc/sliders_output'); ?>
 

    

<!-- .header -->