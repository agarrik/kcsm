<?php

class WooCommerce_Store_Locator_Public
{
    private $plugin_name;
    private $version;
    private $options;

    /**
     * Store Locator Plugin Construct
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @param   string                         $plugin_name 
     * @param   string                         $version    
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Enqueue Styles
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function enqueue_styles()
    {
        global $woocommerce_store_locator_options;

        $this->options = $woocommerce_store_locator_options;

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/woocommerce-store-locator-public.css', array(), $this->version, 'all');
        $doNotLoadBootstrap = $this->get_option('doNotLoadBootstrap');
        if (!$doNotLoadBootstrap) {
            wp_enqueue_style($this->plugin_name.'-bootsrap', plugin_dir_url(__FILE__).'css/bootstrap.min.css', array(), $this->version, 'all');
        }
        wp_enqueue_style($this->plugin_name.'-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), $this->version, 'all');

        $css = '';
        if (!$this->get_option('showName')) {
            $css .= '.store_locator_name{display:none;}';
        }
        if (!$this->get_option('showStreet')) {
            $css .= '.store_locator_street{display:none;}';
        }
        if (!$this->get_option('showCity')) {
            $css .= '.store_locator_city{display:none;}';
        }
        if (!$this->get_option('showCountry')) {
            $css .= '.store_locator_country{display:none;}';
        }
        if (!$this->get_option('showTelephone')) {
            $css .= '.store_locator_tel{display:none;}';
        }
        if (!$this->get_option('showFax')) {
            $css .= '.store_locator_fax{display:none;}';
        }
        if (!$this->get_option('showMobile')) {
            $css .= '.store_locator_mobile{display:none;}';
        }
        if (!$this->get_option('showWebsite')) {
            $css .= '.store_locator_website{display:none;}';
        }
        if (!$this->get_option('showEmail')) {
            $css .= '.store_locator_email{display:none;}';
        }
        if (!$this->get_option('resultListEnabled')) {
            $css .= '.store_locator_result_list_box{display:none;}';
        }
        if (!$this->get_option('mapEnabled')) {
            $css .= '.store_locator_main{display:none;}';
        }
        if (!$this->get_option('searchBoxEnabled')) {
            $css .= '.store_locator_search_box{display:none;}';
        }
        if (!$this->get_option('searchBoxEnabled') && !$this->get_option('resultListEnabled')) {
            $css .= '.store_locator_sidebar{display:none;}';
        }
        if (!$this->get_option('showActiveFilter')) {
            $css .= '#store_locator_filter_active_filter_box{display:none;}';
        }
        if (!$this->get_option('showFilter')) {
            $css .= '#store_locator_filter{display:none;}';
        }
        if (!$this->get_option('showGetDirection')) {
            $css .= '.store_locator_get_direction{display:none !important;}';
        }
        if (!$this->get_option('showCallNow')) {
            $css .= '.store_locator_call_now{display:none !important;}';
        }
        if (!$this->get_option('showVisitWebsite')) {
            $css .= '.store_locator_visit_website{display:none !important;}';
        }
        if (!$this->get_option('showWriteEmail')) {
            $css .= '.store_locator_write_email{display:none !important;}';
        }
        if (!$this->get_option('showImage')) {
            $css .= '.store_locator_image{display:none !important;}';
        }

        $opacity = $this->get_option('loadingOverlayTransparency');
        $css .= '.store_locator_loading{background-color:'.$this->get_option('loadingOverlayColor').';opacity: '.$opacity.';}';
        $css .= '.store_locator_loading i{color:'.$this->get_option('loadingIconColor').';}';
        $css .= '.store_locator_infowindow{width: '.$this->get_option('infowwindowWidth').'px;}';

        $customCSS = $this->get_option('customCSS');

        file_put_contents(__DIR__.'/css/woocommerce-store-locator-custom.css', $css.$customCSS);

        wp_enqueue_style($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'css/woocommerce-store-locator-custom.css', array(), $this->version, 'all');

        return true;
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function enqueue_scripts()
    {
        global $woocommerce_store_locator_options;

        $this->options = $woocommerce_store_locator_options;

        $doNotLoadBootstrap = $this->get_option('doNotLoadBootstrap');
        if (!$doNotLoadBootstrap) {
            wp_enqueue_script($this->plugin_name.'-bootsrap', plugin_dir_url(__FILE__).'js/bootstrap.min.js', array('jquery'), $this->version, true);
        }

        $mapsJS = 'https://maps.google.com/maps/api/js?sensor=false&libraries=places';
        $googleApiKey = $this->get_option('apiKey');
        if (!empty($googleApiKey)) {
            $mapsJS = $mapsJS.'&key='.$googleApiKey;
        }

        wp_enqueue_script($this->plugin_name.'-gmaps', $mapsJS, array(), $this->version, true);
        // wp_enqueue_script( $this->plugin_name.'-multiple-select', plugin_dir_url( __FILE__ ) . 'js/multiple-select.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script($this->plugin_name.'-public', plugin_dir_url(__FILE__).'js/woocommerce-store-locator-public.js', array('jquery', $this->plugin_name.'-gmaps'), $this->version, true);
        $forJS = $woocommerce_store_locator_options;
        $forJS['ajax_url'] = admin_url('admin-ajax.php');
        wp_localize_script($this->plugin_name.'-public', 'store_locator_options', $forJS);

        $customJS = $this->get_option('customJS');
        if (empty($customJS)) {
            return false;
        }

        file_put_contents(__DIR__.'/js/woocommerce-store-locator-custom.js', $customJS);

        wp_enqueue_script($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'js/woocommerce-store-locator-custom.js', array('jquery'), $this->version, false);

        return true;
    }

    /**
     * Get Options
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @param   mixed                         $option The option key
     * @return  mixed                                 The option value
     */
    private function get_option($option)
    {
        if (!array_key_exists($option, $this->options)) {
            return false;
        }

        return $this->options[$option];
    }

    /**
     * Init the Store Locator
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function init_WooCommerce_Store_Locator()
    {
        global $woocommerce_store_locator_options;

        $this->options = $woocommerce_store_locator_options;

        if (!$this->get_option('enable')) {
            return false;
        }

        add_shortcode('woocommerce_store_locator', array($this, 'get_store_locator'));

        // Single Product Button
        if ($this->get_option('buttonEnabled') && class_exists( 'WooCommerce' )) {
            $buttonPosition = $this->get_option('buttonPosition');
            !empty($buttonPosition) ? $buttonPosition = $buttonPosition : $buttonPosition = 'woocommerce_single_product_summary';

            // Go to product page
            if ($this->get_option('buttonAction') == 1) {
                $modalPosition = $this->get_option('buttonModalPosition');
                !empty($modalPosition) ? $modalPosition = $modalPosition : $modalPosition = 'wp_footer';

                add_action($buttonPosition, array($this, 'store_modal_button'), 30);
                add_action($modalPosition, array($this, 'store_modal'), 10);
            }

            // Go to custom URL
            if ($this->get_option('buttonAction') == 2) {
                add_action($buttonPosition, array($this, 'custom_link'), 30);
            }
        }

        return true;
    }

    /**
     * Create the single product button.
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    public function store_modal_button()
    {
        global $product, $woocommerce_store_locator_options;
        $buttonText = $this->get_option('buttonText');

		echo 
        '<button id="store_modal_button" type="button" class="btn button btn-primary btn-lg">'
			. $buttonText . 
		'</button>';
    }

    /**
     * Create the store locator modal
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    public function store_modal()
    {
        global $product;
        $modalSize = $this->get_option('buttonModalSize');

        // Only render Maps Plugin on Product Page (Performance)
        if (!is_product()) {
            return false;
        }
        ?>

		<!-- WooCommerce Store Locator Modal -->
		<div id="store_modal" class="store_modal modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog <?php echo $modalSize ?>" role="document">
				<div class="modal-content">
					<?php $this->get_store_locator(); ?>
				</div>
			</div>
		</div>
	<?php
    }

    /**
     * Create the store locator
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    public function get_store_locator()
    {
        // Layout
        $resultListPosition = $this->get_option('resultListPosition');
        $searchBoxPosition = $this->get_option('searchBoxPosition');
        $mapColumns = $this->get_option('mapColumns');
        // Loading Screen
        $loadingIcon = $this->get_option('loadingIcon');
        $loadingAnimation = $this->get_option('loadingAnimation');
        $loadingIconSize = $this->get_option('loadingIconSize');
        $icon = $loadingIcon.' '.$loadingAnimation.' '.$loadingIconSize;

        ?>

		<div id="store_locator" class="store_locator modal-body">
			<div class="row">
				<?php
                if ($searchBoxPosition == 'above') {
                    $this->get_search_box();
                }

                if ($resultListPosition != 'below') {
                    $this->get_sidebar_content();
                }
                ?>
				<div id="store_locator_main" class="store_locator_main col-sm-<?php echo $mapColumns ?>">
					<div id="store_locator_map" style="height: 100%;"></div>
				</div>
			    <?php
                if ($resultListPosition == 'below') {
                    $this->get_sidebar_content();
                }
                if ($searchBoxPosition == 'below') {
                    $this->get_search_box();
                }
                ?>
			</div>
            <button type="button" id="store_modal_close" class="store_modal_close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div id="store_locator_loading" class="store_locator_loading hidden"><i class="fa <?php echo $icon ?>"></i></div>
		</div>

	<?php
    }

    /**
     * Create the sidebar
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    private function get_sidebar_content()
    {
        $searchBoxPosition = $this->get_option('searchBoxPosition');
        $resultListColumns = $this->get_option('resultListColumns');

        ?>
		<div id="store_locator_sidebar" class="store_locator_sidebar col-sm-<?php echo $resultListColumns ?> <?php echo $resultListPosition ?>">
			<div class="store_locator_sidebar_content" id="store_locator_sidebar_content">
    		<?php
            if ($searchBoxPosition == 'before') {
                $this->get_search_box();
                $this->get_result_list();
            } elseif ($searchBoxPosition == 'after') {
                $this->get_result_list();
                $this->get_search_box();
            } else {
                $this->get_result_list();
            }
            ?>
			</div>
		</div>

		<?php

    }

    /**
     * Get the Search Box
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    private function get_search_box()
    {
        global $post;
        $modalTitle = $this->get_option('buttonModalTitle');
        $buttonText = $this->get_option('buttonText');
        $searchBoxPosition = $this->get_option('searchBoxPosition');
        $searchBoxColumns = $this->get_option('searchBoxColumns');

        if ($searchBoxPosition == 'above' || $searchBoxPosition == 'below') {
            $searchBoxColumns = 'col-sm-'.$searchBoxColumns;
        } else {
            $searchBoxColumns = '';
        }
        ?>

		<div id="store_locator_search_box" class="store_locator_search_box <?php echo $searchBoxColumns ?>">
			<div class="row">
				<div class="col-sm-12">
					<h2 class="store_modal_title"><?php echo $modalTitle ?></h2>
                    <span id="store_locator_filter_active_filter_box" class="store_locator_filter_active_filter_box">
					   <small><?php echo __('Active Filter', 'woocommerce-store-locator' ) ?>:</small> <span id="store_locator_filter_active_filter"></span>
                    </span>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<input id="store_locator_address_field" class="store_locator_address_field" type="text" name="location" placeholder="Enter your address">
					<a href="#" id="store_locator_get_my_position"><i><?php echo __('Get my Position', 'woocommerce-store-locator' ) ?></i></a>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<button id="store_locator_find_stores_button" type="button" class="store_locator_find_stores_button btn button btn-primary btn-lg">
						<?php echo $buttonText ?>
					</button>
				</div>
			</div>
			<div class="row">
				<?php
                $this->get_filter();
                ?>
			</div>
		</div>

		<?php

    }

    /**
     * Get the result list
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    private function get_result_list()
    {
        ?>
		<div id="store_locator_result_list_box" class="store_locator_result_list_box">
			<h2 class="store_locator_result_list_title"><?php echo __('Results', 'woocommerce-store-locator' ) ?></h2>
			<div id="store_locator_result_list">
                
            </div>
		</div>
		<?php

    }

    /**
     * Get the filter
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    private function get_filter()
    {
        global $post;

        $mapRadiusSteps = $this->get_option('mapRadiusSteps');
        $mapRadius = $this->get_option('mapRadius');
        $mapDistanceUnit = $this->get_option('mapDistanceUnit');
        $categories = get_terms('store_category');
        $filter = get_terms('store_filter');

        // Preselect store category if it is connected to a product category
        $product_categories = array();
        $terms = get_the_terms($post->ID, 'product_cat');
        if (isset($terms) && !empty($terms) && is_array($terms)) {
            foreach ($terms as $term) {
                $product_categories[] = $term->term_id;
            }
        }
        ?>

		<div id="store_locator_filter" class="store_locator_filter">
			<div id="store_locator_filter_open_close" class="store_locator_filter_open_close col-sm-12">
				<h2 class="store_locator_filter_title"><?php echo __('Filter', 'woocommerce-store-locator' ) ?></h2> <i class="fa fa-chevron-down text-right"></i>
			</div>
			<div id="store_locator_filter_content" class="store_locator_filter_content hidden">
				<div class="col-sm-12 single_filter">
					<select name="categories" id="store_locator_filter_categories" class="select store_locator_filter_categories">
						<option value=""><?php echo __('Select a Category', 'woocommerce-store-locator' ) ?></option>
    					<?php
                        foreach ($categories as $category) {
                            $linked_category = get_term_meta($category->term_id, 'woocommerce_store_locator_product_category');
                            // echo $linked_category[0];

                            if (in_array($linked_category[0], $product_categories)) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="'.$category->term_id.'" '.$selected.'>'.$category->name.'</option>';
                        }
                        ?>
					</select>
				</div>
				<div class="col-sm-12 single_filter">
					<h5>Radius</h5>
					<select name="radius" id="store_locator_filter_radius" class="select store_locator_filter_radius">
					<?php
                        $mapRadiusSteps = explode(',', $mapRadiusSteps);
                        foreach ($mapRadiusSteps as $mapRadiusStep) {
                            if ($mapRadius == $mapRadiusStep) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            echo '<option value="'.$mapRadiusStep.'" '.$selected.'>'.$mapRadiusStep.' '.$mapDistanceUnit.'</option>';
                        }
                        ?>
					</select>
				</div>
				<?php
                $temp = array();
                $this->sort_terms_hierarchicaly($filter, $temp);
                $filter = $temp;
                foreach ($filter as $singleFilter) {
                    echo '<div class="col-sm-12 single_filter">';
                    echo '<h5>'.$singleFilter->name.'</h5>';

                    if (isset($singleFilter->children)) {
                        foreach ($singleFilter->children as $singleFilterChild) {
                            $linked_category = get_term_meta($singleFilterChild->term_id, 'woocommerce_store_locator_product_category');

                            if (in_array($linked_category[0], $product_categories)) {
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }

                            echo '<label class="single_filter_checkbox control control--checkbox"><input '.$checked.' name="'.$singleFilterChild->term_id.'" type="checkbox" class="store_locator_filter_checkbox" value="'.$singleFilterChild->name.'">'.$singleFilterChild->name.'<div class="control__indicator"></div></label>';
                        }
                    }
                    echo '</div>';
                }
                ?>
			</div>
		</div>
		<?php

    }

    /**
     * Create a Custom Link
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     */
    public function custom_link()
    {
        $buttonText = $this->get_option('buttonText');
        $buttonURL = $this->get_option('buttonActionURL');
        $buttonTarget = $this->get_option('buttonActionURLTarget');

        echo    '<a id="store_locator_custom_bottom" target="'.$buttonTarget.'" href="'.$buttonURL.'" class="store_locator_custom_bottom button alt">'
                    . $buttonText .
                '</a>';
    }

    /**
     * Sort Wordpress Terms Hierarchicaly
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @param   array                          &$cats
     * @param   array                          &$into
     * @param   integer                        $parentId
     * @return  array
     */
    private function sort_terms_hierarchicaly(array &$cats, array &$into, $parentId = 0)
    {
        foreach ($cats as $i => $cat) {
            if ($cat->parent == $parentId) {
                $into[$cat->term_id] = $cat;
                unset($cats[$i]);
            }
        }

        foreach ($into as $topCat) {
            $topCat->children = array();
            $this->sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
        }
    }
}
