<?php
/**
 * Custom Post Type for Stores and Taxonomies.
 */
class WooCommerce_Store_Locator_Post_Type
{
    private $plugin_name;
    private $version;
    /**
     * Constructor.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @param string $plugin_name
     * @param string $version
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_filter('manage_stores_posts_columns', array($this, 'columns_head'));
        add_action('manage_stores_posts_custom_column', array($this, 'columns_content'), 10, 1);
    }

    /**
     * Init.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @return bool
     */
    public function init_WooCommerce_Store_Locator_Post_Type()
    {
        $this->register_store_locator_post_type();
        $this->register_store_locator_taxonomy();
        $this->add_custom_meta_fields();
    }

    /**
     * Register Store Post Type.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @return bool
     */
    public function register_store_locator_post_type()
    {
        $singular = __('Store', 'woocommerce-store-locator');
        $plural = __('Stores', 'woocommerce-store-locator');

        $labels = array(
            'name' => __('Store Locator', 'woocommerce-store-locator'),
            'all_items' => sprintf(__('All %s', 'woocommerce-store-locator'), $plural),
            'singular_name' => $singular,
            'add_new' => sprintf(__('New %s', 'woocommerce-store-locator'), $singular),
            'add_new_item' => sprintf(__('Add New %s', 'woocommerce-store-locator'), $singular),
            'edit_item' => sprintf(__('Edit %s', 'woocommerce-store-locator'), $singular),
            'new_item' => sprintf(__('New %s', 'woocommerce-store-locator'), $singular),
            'view_item' => sprintf(__('View %s', 'woocommerce-store-locator'), $plural),
            'search_items' => sprintf(__('Search %s', 'woocommerce-store-locator'), $plural),
            'not_found' => sprintf(__('No %s found', 'woocommerce-store-locator'), $plural),
            'not_found_in_trash' => sprintf(__('No %s found in trash', 'woocommerce-store-locator'), $plural),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'exclude_from_search' => true,
            'show_ui' => true,
            'menu_position' => 57,
            'rewrite' => false,
            'query_var' => 'stores',
            'supports' => array('title', 'editor', 'author', 'revisions', 'thumbnail'),
            'menu_icon' => 'dashicons-location-alt',
            // 'taxonomies' => array('post_tag'),
        );

        register_post_type('stores', $args);
    }

    /**
     * Register Store Categories and Store Filter Taxonomies.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @return bool
     */
    public function register_store_locator_taxonomy()
    {
    	// Store Category
        $singular = __('Store Category', 'woocommerce-store-locator');
        $plural = __('Store Categories', 'woocommerce-store-locator');

        $labels = array(
            'name' => sprintf(__('%s', 'woocommerce-store-locator'), $plural),
            'singular_name' => sprintf(__('%s', 'woocommerce-store-locator'), $singular),
            'search_items' => sprintf(__('Search %s', 'woocommerce-store-locator'), $plural),
            'all_items' => sprintf(__('All %s', 'woocommerce-store-locator'), $plural),
            'parent_item' => sprintf(__('Parent %s', 'woocommerce-store-locator'), $singular),
            'parent_item_colon' => sprintf(__('Parent %s:', 'woocommerce-store-locator'), $singular),
            'edit_item' => sprintf(__('Edit %s', 'woocommerce-store-locator'), $singular),
            'update_item' => sprintf(__('Update %s', 'woocommerce-store-locator'), $singular),
            'add_new_item' => sprintf(__('Add New %s', 'woocommerce-store-locator'), $singular),
            'new_item_name' => sprintf(__('New %s Name', 'woocommerce-store-locator'), $singular),
            'menu_name' => sprintf(__('%s', 'woocommerce-store-locator'), $plural),
        );

        $args = array(
                'labels' => $labels,
                'public' => false,
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => 'store-categories'),
        );

        register_taxonomy('store_category', 'stores', $args);

        // Store Filter
        $singular = __('Store Filter', 'woocommerce-store-locator');
        $plural = __('Store Filter', 'woocommerce-store-locator');
        $labels = array(
            'name' => sprintf(__('%s', 'woocommerce-store-locator'), $plural),
            'singular_name' => sprintf(__('%s', 'woocommerce-store-locator'), $singular),
            'search_items' => sprintf(__('Search %s', 'woocommerce-store-locator'), $plural),
            'all_items' => sprintf(__('All %s', 'woocommerce-store-locator'), $plural),
            'parent_item' => sprintf(__('Parent %s', 'woocommerce-store-locator'), $singular),
            'parent_item_colon' => sprintf(__('Parent %s:', 'woocommerce-store-locator'), $singular),
            'edit_item' => sprintf(__('Edit %s', 'woocommerce-store-locator'), $singular),
            'update_item' => sprintf(__('Update %s', 'woocommerce-store-locator'), $singular),
            'add_new_item' => sprintf(__('Add New %s', 'woocommerce-store-locator'), $singular),
            'new_item_name' => sprintf(__('New %s Name', 'woocommerce-store-locator'), $singular),
            'menu_name' => sprintf(__('%s', 'woocommerce-store-locator'), $plural),
        );

        $args = array(
                'labels' => $labels,
                'public' => false,
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => 'store-filter'),
        );

        register_taxonomy('store_filter', 'stores', $args);
    }

    /**
     * Add Custom Meta Fields to Store Categories and Filters.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @return bool
     */
    public function add_custom_meta_fields()
    {
        $prefix = 'woocommerce_store_locator_';
        $custom_taxonomy_meta_config = array(
            'id' => 'stores_meta_box',
            'title' => 'Stores Meta Box',
            'pages' => array('store_category', 'store_filter'),
            'context' => 'side',
            'fields' => array(),
            'local_images' => false,
            'use_with_theme' => false,
        );

        $custom_taxonomy_meta_fields = new Tax_Meta_Class($custom_taxonomy_meta_config);
        // $custom_taxonomy_meta_fields->addImage($prefix.'image', array('name' => __('Map Icon ', 'tax-meta')));
        // No ID!
        // $custom_taxonomy_meta_fields->addTaxonomy($prefix.'product_category',array('taxonomy' => 'product_cat'),array('name'=> __('Link to Product Category ','tax-meta')));

        $options = array('' => 'Select Category');
        $categories = get_terms('product_cat');
        if(is_array($categories)) {
            foreach ($categories as $category) {
                $options[$category->term_id] = $category->name;
            }
            $custom_taxonomy_meta_fields->addSelect($prefix.'product_category', $options, array('name' => __('Link to Product Category ', 'tax-meta')));
        }
        $custom_taxonomy_meta_fields->Finish();
    }

    /**
     * Columns Head.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @param string $columns Columnd
     *
     * @return string
     */
    public function columns_head($columns)
    {
        $output = array();
        foreach ($columns as $column => $name) {
            $output[$column] = $name;

            if ($column === 'title') {
                $output['address'] = __('Address', 'woocommerce-store-locator');
                $output['contact'] = __('Contact', 'woocommerce-store-locator');
            }
        }

        return $output;
    }

    /**
     * Columns Content.
     *
     * @author Daniel Barenkamp
     *
     * @version 1.0.0
     *
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     *
     * @param string $column_name Column Name
     *
     * @return string
     */
    public function columns_content($column_name)
    {
        global $post;

        if ($column_name == 'address') {
            $address['address1'] = rwmb_meta('woocommerce_store_locator_address1');
            $address['address2'] = rwmb_meta('woocommerce_store_locator_address2');
            $address['city'] = rwmb_meta('woocommerce_store_locator_zip').', '.rwmb_meta('woocommerce_store_locator_city');
            $address['country'] = rwmb_meta('woocommerce_store_locator_region').', '.rwmb_meta('woocommerce_store_locator_country');

            echo implode('<br/>', array_filter($address));
        }

        if ($column_name == 'contact') {
            $contact['telephone'] = __('Tel.:', 'woocommerce-store-locator').' '.rwmb_meta('woocommerce_store_locator_telephone');
            $contact['mobile'] = __('Mobile:', 'woocommerce-store-locator').' '.rwmb_meta('woocommerce_store_locator_mobile');
            $contact['email'] = __('Email:', 'woocommerce-store-locator').' <a href="mailto'.rwmb_meta('woocommerce_store_locator_email').'"> '.rwmb_meta('woocommerce_store_locator_email').'</a>';
            $contact['website'] = __('Website:', 'woocommerce-store-locator').' <a href="'.rwmb_meta('woocommerce_store_locator_website').'"> '.rwmb_meta('woocommerce_store_locator_website').'</a>';

            echo implode('<br/>', array_filter($contact));
        }
    }
}
