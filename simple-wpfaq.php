<?php
/*
Plugin Name: Simple wpFAQ
Description: This plugin is necessary for the FAQs displayed on this website.
Version: 1.0
Author: Scott Lee
Author URI: http://scottlee.me
*/


// require_once( 'views/getFAQs.php' );

class simplewpFAQ {

    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/

    function __construct() {

        add_action( 'init', array( $this, 'register_faq_cpt' ) );
        add_action( 'init', array( $this, 'register_faq_taxonomy' ) );
        add_action( 'admin_head', array( $this, 'faq_menu_icon' ) );
        add_action('manage_faq_posts_custom_column', array( $this, 'faq_custom_column'), 10, 2);

        add_filter( 'manage_faq_posts_columns', array( $this, 'faq_columns') );

    }


    /*--------------------------------------------*
     * Core Functions
     *---------------------------------------------*/

    /**
     * Register FAQ Post Type
     */
    function register_faq_cpt() {

        $labels = array(
        'name' => _x( 'FAQs', 'faq' ),
        'singular_name' => _x( 'FAQ', 'faq' ),
        'add_new' => _x( 'Add New', 'faq' ),
        'add_new_item' => _x( 'Add New FAQ', 'faq' ),
        'edit_item' => _x( 'Edit FAQ', 'faq' ),
        'new_item' => _x( 'New FAQ', 'faq' ),
        'view_item' => _x( 'View FAQ', 'faq' ),
        'search_items' => _x( 'Search FAQs', 'faq' ),
        'not_found' => _x( 'No faqs found', 'faq' ),
        'not_found_in_trash' => _x( 'No faqs found in Trash', 'faq' ),
        'parent_item_colon' => _x( 'Parent FAQ:', 'faq' ),
        'menu_name' => _x( 'FAQs', 'faq' ),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,

            'supports' => array( 'title', 'editor' ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/faq-menu-small.png',
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post'
        );

        register_post_type( 'faq', $args );
    }

    /**
     * Register FAQ Taxonomy
     */
    function register_faq_taxonomy() {

        $labels = array(
            'name' => _x( 'FAQ Categories', 'faq category' ),
            'singular_name' => _x( 'FAQ Category', 'faq category' ),
            'search_items' => _x( 'Search FAQ Categories', 'faq category' ),
            'popular_items' => _x( 'Popular FAQ Categories', 'faq category' ),
            'all_items' => _x( 'All FAQ Categories', 'faq category' ),
            'parent_item' => _x( 'Parent FAQ Category', 'faq category' ),
            'parent_item_colon' => _x( 'Parent FAQ Category:', 'faq category' ),
            'edit_item' => _x( 'Edit FAQ Category', 'faq category' ),
            'update_item' => _x( 'Update FAQ Category', 'faq category' ),
            'add_new_item' => _x( 'Add New FAQ Category', 'faq category' ),
            'new_item_name' => _x( 'New FAQ Category', 'faq category' ),
            'separate_items_with_commas' => _x( 'Separate faq categories with commas', 'faq category' ),
            'add_or_remove_items' => _x( 'Add or remove FAQ Categories', 'faq category' ),
            'choose_from_most_used' => _x( 'Choose from most used FAQ Categories', 'faq category' ),
            'menu_name' => _x( 'FAQ Categories', 'faq category' ),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => false,

            'rewrite' => true,
            'query_var' => true
        );
        register_taxonomy( 'faq_category', array('faq'), $args );
    }

    /**
     * Change icon on the FAQ edit screen
     */
    function faq_menu_icon() {
        global $post_type; ?>

        <style>
        <?php if ( ($_GET['post_type'] == 'faq') ) : ?>
            #icon-edit { background:transparent url( <?php echo plugin_dir_url( __FILE__ ) . 'images/faq-menu-large.png'; ?>) no-repeat; }
        <?php endif; ?>
        </style>
    <?php }

    /**
     * Add FAQ taxonomy column to FAQs
     */
    function faq_columns($defaults) {
        $defaults['faq_category'] = 'FAQ Category';
        return $defaults;
    }

    function faq_custom_column($column_name, $post_id) {
        $taxonomy = $column_name;
        $post_type = get_post_type($post_id);
        $terms = get_the_terms($post_id, $taxonomy);

        if ( !empty($terms) ) {
            foreach ( $terms as $term )
                $post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
            echo join( ', ', $post_terms );
        } else {
            echo '<i>No terms.</i>';
        }
    }

} // end class

$travois_faqs = new simplewpFAQ();