<?php

	/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $carousel
 * @var $dark_light
 * @var $controls
 * Shortcode class
 * @var $this WPBakeryShortCode_Client
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


	

        $clients = themeple_get_option('client-logo');



        $output = '<div class="'.$dark_light.'_clients clients_el '.$carousel.'">';
        if(!empty($title))
        $output .= '<div class="header"><h2>'.$title.'</h2></div>';

        $output .= '<section class="row clients clients_caro">';

        $i = 0;

        foreach($clients as $client):                            
                $i ++;
                if($dark_light == 'light'){
                    $client['logo'] = $client['logo_light'];
                }


                $output .= '                    <div class="item">

                                                    <a href="'.$client['link'].'"  title="'.$client['title'].'">

                                                        <img src="'.$client['logo'].'" alt="'.$client['title'].'" >

                                                        

                                                    </a></div>';

                if($i == 3){
                        $output .= '<div class="separator"></div>';
                }

        endforeach;

                          

        $output .= '</section>';
        if($controls == 'yes')
        $output .='<div class="controls"><a  class="prev"></a><a class="next"></a></div>';

        $output .= '</div>';





        echo $output;

	

?>