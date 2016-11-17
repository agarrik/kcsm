<?php
global $themeple_config;
do_action('themeple_excecute_query_var_action','loop-single_portfolio_bottom');
//$metas = themeple_portfolio_custom_field(get_the_ID());
$metas = themeple_post_meta(get_the_ID());
$output = '';
$cats = wp_get_object_terms(get_the_ID(), 'portfolio_entries');
$used_template = themeple_get_option_array('portfolio', 'portfolio_cats', $cats[0]->term_id, true);
$big_title_bool = themeple_post_meta(get_the_ID(), 'big_title_bool');
$port_nav=themeple_get_option_array('portfolio', 'port_nav_bool', false, true);
?>

      <?php      if($port_nav[0]['port_nav_bool'] == 'yes'): ?>
    <div class="row-fluid portfolio_single_header">
  
                <ul class="portfolio_single_nav">
                      <?php if(is_object(get_previous_post())): ?>         
                        <li class="prev"><a href="<?php echo get_permalink(get_previous_post()->ID); ?>">Previous</a></li>
                      <?php endif; ?>
                        <li class="all"><a href="<?php echo get_permalink($used_template['portfolio_page']); ?>">Back</a></li>
                      <?php if(is_object(get_next_post())): ?>
                        <li class="next"><a href="<?php echo get_permalink(get_next_post()->ID); ?>">Next</a></li>
                      <?php endif; ?>
                </ul>
          
    </div>  
    <?php  endif; ?>     
            <div class="row-fluid">
                <div class="span12 single_content bottom with_thumbnails_container">
            <?php $slider = new themeple_slideshow(get_the_ID(), 'flexslider_thumb');
                       
                                      if($slider && $slider->slide_number > 0){
						                                $slider->img_size = 'blog';
                                            $sliderHtml = $slider->render_slideshow();
                                            echo $sliderHtml;
                                      }
                       

             ?>
                </div>
            </div>
            <?php 

                $portfolio_metas = themeple_get_option('portfolio-meta'); 
                $counter = 0;

            ?>
                      
            <div class="row-fluid row-dynamic-el">
                    <div class="span12 single_content bottom">
                        <div class="span8">
                          <h1><?php the_title(); ?></h1>
                          <?php the_content(); ?>
                         
                          </div>
                        <div class="span1">
                          
                        </div>
                        <div class="span3">

                   
                          
                  <?php 

                          $portfolio_metas = themeple_get_option('portfolio-meta'); 
                          $counter = 0;

                          ?>
                      
                          
                    

                          <div class="meta-content">
                                  <div class="meta">
                                  <span><?php _e('Category', 'themeple') ?>:&nbsp;&nbsp;  </span>
                                         <p class="cats">      
                        <?php 
                            $post_id = get_the_ID();
                           
                            $portfolio_cates = wp_get_object_terms( $post->ID,  'portfolio_entries' );
                              
                            $i = 0;
                                $len = count($portfolio_cates);

                                    foreach($portfolio_cates as $c):
                                        if($i == $len - 1 )

                                            echo $c->name;
                                        else

                                            echo $c->name.', ';

                                        $i++;

                                    endforeach;            
                            ?>
                        </p>  
                               <div class="meta">
                                   <span><?php _e('Date', 'themeple') ?>: &nbsp;&nbsp; </span>
                                      <p> <?php echo get_the_date(); ?> </p>
                                      
                                  </div>
                               
                                 
                                   <?php foreach($portfolio_metas as $meta): $counter++; ?>
                                        <?php if(!empty($metas['meta_'.$counter])): ?>
                                          <div class="meta">
                                          
                                         

                                      
                                                       
                                            <span><?php echo ucfirst($meta['meta']) ?>:&nbsp;&nbsp;</span>
                                                    
                                          <div class="custom_content">
                                                      <p><?php echo do_shortcode($metas['meta_'.$counter]) ?></p>
                                          </div>          

                                          

                                          </div>
                                      
                                      
                                     
                                   
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                  
                               
                            </div>         
     
                        </div>      

                    </div>
            </div>   
            
