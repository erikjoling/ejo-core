<?php
/**
 * EJO Core: A theme drop-in framework by EJOweb
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Core
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2018, Erik Joling
 * @link      https://github.com/erikjoling/ejo-core
 */

/**
 * Singleton
 */
final class EJO_Core {
    
    // Version number
    public $version = '0.3.3';

    // Store the slug
    public $slug = 'ejo-core';

    /**
     * Framework directory path with trailing slash.
     *
     * @access public
     * @var    string
     */
    public $dir = '';

    /**
     * Framework directory URI with trailing slash.
     *
     * @access public
     * @var    string
     */
    public $uri = '';

    /**
     * Framework directory path with trailing slash.
     *
     * @access public
     * @var    string
     */
    public $theme_dir = '';

    /**
     * Framework directory URI with trailing slash.
     *
     * @access public
     * @var    string
     */
    public $theme_uri = '';

    /**
     * Returns the instance.
     *
     * @access public
     * @return object
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self;
            $instance->setup();
            $instance->setup_actions();
        }

        return $instance;
    }

    /**
     * Clone method.
     *
     * @access private
     * @return void
     */
    private function __clone() {}
    
    /**
     * Constructor method.
     *
     * @access private
     * @return void
     */
    private function __construct() {}

    /**
     * Sets up the framework.
     *
     * @access private
     * @return void
     */
    private function setup() {

        // Set Theme Directory Constants
        if ( ! defined( 'THEME_DIR' ) ) define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
        if ( ! defined( 'THEME_URI' ) ) define( 'THEME_URI', trailingslashit( get_template_directory_uri() ) );

        // Set the directory properties.
        $this->theme_dir = THEME_DIR;
        $this->theme_uri = THEME_URI;

        // Abort if EJO_CORE_DIR or EJO_CORE_URI are not defined.
        if ( ! defined( 'EJO_CORE_DIR' ) || ! defined( 'EJO_CORE_URI' ) ) {
            wp_die( '`EJO_CORE_DIR` and `EJO_CORE_URI` should be defined before calling EJO-core framework', 'Error while setting up EJO-core' );
        } 
        
        // Set the framework properties
        $this->dir = EJO_CORE_DIR;
        $this->uri = EJO_CORE_URI;
    }

    /**
     * Sets up the framework.
     *
     * @access private
     * @return void
     */
    private function setup_actions() {
        
        add_action( 'after_setup_theme', array( $this, 'constants' ),    -95 ); // Setup plugin
        add_action( 'after_setup_theme', array( $this, 'helpers' ),       -1 ); // Make helpers available early on
        add_action( 'after_setup_theme', array( $this, 'templating' ),     8 ); // Templating
        add_action( 'after_setup_theme', array( $this, 'theme_support' ),  9 ); // Theme Support
        add_action( 'after_setup_theme', array( $this, 'mold' ),          15 ); // Molding WordPress. Loaded after theme setup so themes can manipulate it
        add_action( 'after_setup_theme', array( $this, 'ejopack' ),       15 ); // EJOpack. Should be extracted a plugin    
    }

    /* Defines Constants. */
    public function constants() {

        //* Define Includes Directory
        if ( ! defined( 'THEME_INC_DIR' ) ) define( 'THEME_INC_DIR', $this->theme_dir . 'includes/' );
        if ( ! defined( 'THEME_INC_URI' ) ) define( 'THEME_INC_URI', $this->theme_uri . 'includes/' );
        
        // Composer Vendor Dir
        if ( ! defined( 'THEME_VENDOR_DIR' ) ) define( 'THEME_VENDOR_DIR', $this->theme_dir . 'vendor/' );

        //* Set Version
        if ( ! defined( 'THEME_VERSION' ) ) define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );

        //* Set paths to asset folders.
        if ( ! defined( 'THEME_IMG_URI' ) )    define( 'THEME_IMG_URI',    $this->theme_uri . 'assets/images/' );
        if ( ! defined( 'THEME_JS_URI' ) )     define( 'THEME_JS_URI',     $this->theme_uri . 'assets/js/' );
        if ( ! defined( 'THEME_CSS_URI' ) )    define( 'THEME_CSS_URI',    $this->theme_uri . 'assets/css/' );
        if ( ! defined( 'THEME_FONT_URI' ) )   define( 'THEME_FONT_URI',   $this->theme_uri . 'assets/fonts/' );    
        if ( ! defined( 'THEME_VENDOR_URI' ) ) define( 'THEME_VENDOR_URI', $this->theme_uri . 'assets/vendor/' );
    }

    /* Add helper functions */
    public function helpers() {

        require_once( $this->dir . 'includes/helpers/write-log.php' );       // Write Log
        require_once( $this->dir . 'includes/helpers/misc.php' );            // Theme helpers
        require_once( $this->dir . 'includes/helpers/enqueue-plugins.php' ); // Make it easy to add shipped common assets like magnific-popup
        require_once( $this->dir . 'includes/helpers/carbon-fields.php' );   // Carbon Fields
    }

    /* Templating Logic */
    public function templating() 
    {
        require_once( $this->dir . 'includes/templating/template-helpers.php' );     // Template helpers
        require_once( $this->dir . 'includes/templating/template.php' );             // Main template functionality
        require_once( $this->dir . 'includes/templating/template-post.php' );        // Template post functions
        require_once( $this->dir . 'includes/templating/template-functions.php' );   // Template functions
        require_once( $this->dir . 'includes/templating/template-hierarchy.php' );   // Template hierarchy
        require_once( $this->dir . 'includes/templating/template-tags.php' );        // Template Tags
        require_once( $this->dir . 'includes/templating/template-context.php' );     // Template context

        // Widget Template Loader Class
        require_once( $this->dir . 'includes/templating/widget-template-loader/widget-template-loader.php' ); 
    }

    /* Manage theme support */
    public function theme_support() 
    {
        /* WordPress Core */
        add_theme_support( 'automatic-feed-links' ); // Add default posts and comments RSS feed links to head.
        add_theme_support( 'title-tag' );            // Automatically add <title> to head.
        add_theme_support( 'post-thumbnails' );      // Adds theme support for WordPress 'featured images'.
        add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) ); // Adds core WordPress HTML5 support.

        /* Plugins */
        add_theme_support( 'yoast-seo-breadcrumbs' ); // Yoast Breadcrumbs

        /* Ejo Core */
        add_theme_support( 'ejo-cleanup-header' );  // Cleanup Header
        add_theme_support( 'ejo-cleanup-widgets' ); // Cleanup Widgets
        add_theme_support( 'ejo-disable-xmlrpc' );  // Disable XMLRPC
        add_theme_support( 'ejo-disable-emojis' );  // Disable Emojis
        add_theme_support( 'ejo-admin-menu' );      // Ejo Admin menu
        add_theme_support( 'ejo-admin-dashboard' ); // Ejo Admin-dashboard
        add_theme_support( 'ejo-text-editor' );     // Ejo Text-editor
        add_theme_support( 'ejo-site-scripts' );    // Custom Site Scripts
        add_theme_support( 'ejo-shortcodes' );      // Shortcodes

        /** 
         * Not supported functionality by default 
         */ 
        
        /* WordPress */
        // add_theme_support( 'post-formats', array() );
        // add_theme_support( 'custom-background', array() );
        // add_theme_support( 'custom-header', array() );
        // add_theme_support( 'custom-logo', array() );
        // add_theme_support( 'starter-content', array() );
        // add_theme_support( 'customize-selective-refresh-widgets' );

        /* Ejo Core */
        // add_theme_support( 'ejo-hide-blogging' );      // Hide blogging
        // add_theme_support( 'ejo-post-scripts' );       // Add scripts to posts
        // add_theme_support( 'ejo-social-media-links' ); // Social Media Links
    }
    
    /* Molding WordPress */
    public function mold() 
    {
        //* Remove/disable/hide unnecessary functionality

        /* Hide Blogging functionality */
        require_if_theme_supports( 'ejo-hide-blogging', $this->dir . 'includes/hide-blogging.php' );

        /* Cleanup unnecessary HTML Header elements */
        require_if_theme_supports( 'ejo-cleanup-header', $this->dir . 'includes/cleanup-html-header.php' );

        /* Disable unnecessary XML-RPC and Pingback functionality */
        require_if_theme_supports( 'ejo-disable-xmlrpc', $this->dir . 'includes/disable-xmlrpc.php' );

        /* Cleanup unnecessary widgets */
        require_if_theme_supports( 'ejo-cleanup-widgets', $this->dir . 'includes/cleanup-widgets.php' );

        /* Disable emoji support */
        require_if_theme_supports( 'ejo-disable-emojis', $this->dir . 'includes/disable-emojis.php' );

        //* Tweak WordPress Admin

        /* Mold the admin menu to my liking */
        require_if_theme_supports( 'ejo-admin-menu', $this->dir . 'includes/admin-menu.php' );

        /* Mold the admin dashboard to my liking */
        require_if_theme_supports( 'ejo-admin-dashboard', $this->dir . 'includes/admin-dashboard.php');

        /* Mold the text editor to my liking */
        require_if_theme_supports( 'ejo-text-editor', $this->dir . 'includes/text-editor.php' ); 
    }

    /* Functionality to extract to a plugin */
    public function ejopack() 
    {
        /* Allow admin to add scripts to entire site */
        require_if_theme_supports( 'ejo-site-scripts', $this->dir . '_ejopack/custom-scripts/add-site-scripts.php' );

        /* Allow admin to add scripts to specific posts */
        require_if_theme_supports( 'ejo-post-scripts', $this->dir . '_ejopack/custom-scripts/add-post-scripts.php' );

        /* Social Media */
        require_if_theme_supports( 'ejo-social-media-links', $this->dir . '_ejopack/social-media/links/social-media-links.php');

        /* Shortcodes */
        require_if_theme_supports( 'ejo-shortcodes', $this->dir . '_ejopack/shortcodes/shortcodes.php' );
    }
}

/**
 * Gets the instance of the `EJO_Core` class.  This function is useful for quickly grabbing data
 * used throughout the framework.
 *
 * @access public
 * @return object
 */
function ejo_core() {
    return EJO_Core::get_instance();
}

// Startup!
ejo_core();