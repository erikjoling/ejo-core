<?php
/**
 * EJO Core: A theme drop-in framework by EJOweb
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Core
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2017, Erik Joling
 * @link      https://github.com/erikjoling/ejo-core
 */

/**
 * Singleton
 */
final class EJO_Core 
{
    /* Holds the instance of this Singleton class. */
    private static $_instance = null;

    /* Version number of this plugin */
    public static $version = '0.1';

    /* Store the slug of this plugin */
    public static $slug = 'ejo-core';

    /* Stores the directory path for this plugin. */
    public static $dir;

    /* Stores the directory URI for this plugin. */
    public static $uri;

    /**
     * Singleton implementation (Only instantiate once)
     */
    public static function load() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* No cloning
    private function __clone() {}

    /* Plugin setup. */
    private function __construct() 
    {
        /* Setup plugin */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'setup' ), -95 );

        /* Make helpers immediatly available */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'helpers' ), 0 );

        /* Templating */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'templating' ), 5 );

        /* Molding WordPress. Loaded after theme setup so themes can manipulate it */        
        add_action( 'after_setup_theme', array( 'EJO_Core', 'mold' ), 10 );

        /* EJOpack. Should be extracted a plugin */        
        add_action( 'after_setup_theme', array( 'EJO_Core', 'ejopack' ), 10 );
    }

    
    /* Defines the directory path and URI. */
    public static function setup() 
    {
        self::$dir = plugin_dir_path( __FILE__ );
        self::$uri = plugin_dir_url( __FILE__ );

        $relative_framework_path = trailingslashit( apply_filters( 'ejocore_relative_framework_path', 'includes/vendor/' ) );

        // Sets the path to the core framework directory.
        if ( ! defined( 'EJO_CORE_DIR' ) )
            define( 'EJO_CORE_DIR', trailingslashit( THEME_DIR . $relative_framework_path . basename( dirname( __FILE__ ) ) ) );

        // Sets the path to the core framework directory URI.
        if ( ! defined( 'EJO_CORE_URI' ) ) {
            define( 'EJO_CORE_URI', trailingslashit( THEME_URI . $relative_framework_path . basename( dirname( __FILE__ ) ) ) );
        }
    }

    /* Add helper functions */
    public static function helpers() 
    {
        /* Write Log */
        require_once( self::$dir . 'includes/_helpers/write-log.php' );

        /* Theme helpers */
        require_once( self::$dir . 'includes/_helpers/misc.php' );
    }

    /* Templating Logic */
    public static function templating() 
    {
        /* Template functions */
        require_once( self::$dir . 'includes/templating/template-functions.php' );

        /* Template Structure */
        require_once( self::$dir . 'includes/templating/template-structure.php' );

        /* Template Tags */
        require_once( self::$dir . 'includes/templating/template-tags.php' );

        /* Template misc */
        require_once( self::$dir . 'includes/templating/template-misc.php' );

        /* Widget Template Loader Class */
        require_once( self::$dir . 'includes/templating/widget-template-loader/widget-template-loader.php' );
    }
    
    /* Molding WordPress */
    public static function mold() 
    {
        //* Remove/disable/hide unnecessary functionality

        /* Hide Blogging functionality */
        require_if_theme_supports( 'hide-blogging', self::$dir . 'includes/hide-blogging.php' );

        /* Cleanup unnecessary HTML Header elements */
        require_if_theme_supports( 'cleanup-header', self::$dir . 'includes/cleanup-html-header.php' );

        /* Disable unnecessary XML-RPC and Pingback functionality */
        require_if_theme_supports( 'disable-xmlrpc', self::$dir . 'includes/disable-xmlrpc.php' );

        /* Cleanup unnecessary widgets */
        require_if_theme_supports( 'cleanup-widgets', self::$dir . 'includes/cleanup-widgets.php' );

        /* Disable emoji support */
        require_if_theme_supports( 'disable-emojis', self::$dir . 'includes/disable-emojis.php' );

        //* Tweak WordPress Admin

        /* Mold the admin menu to my liking */
        require_if_theme_supports( 'ejo-admin-menu', self::$dir . 'includes/ejo-admin-menu.php' );

        /* Mold the admin dashboard to my liking */
        require_if_theme_supports( 'ejo-admin-dashboard', self::$dir . 'includes/ejo-admin-dashboard.php');

        /* Mold the text editor to my liking */
        require_if_theme_supports( 'ejo-text-editor', self::$dir . 'includes/ejo-text-editor.php' ); 
    }

    /* Functionality to extract to a plugin */
    public static function ejopack() 
    {
        /* Allow admin to add scripts to entire site */
        require_if_theme_supports( 'site-scripts', self::$dir . '_ejopack/custom-scripts/add-site-scripts.php' );

        /* Allow admin to add scripts to specific posts */
        require_if_theme_supports( 'post-scripts', self::$dir . '_ejopack/custom-scripts/add-post-scripts.php' );

        /* Social Media */
        require_if_theme_supports( 'social-media-links', self::$dir . '_ejopack/social-media/links/social-media-links.php');

        /* Shortcodes */
        require_if_theme_supports( 'ejo-shortcodes', self::$dir . '_ejopack/shortcodes/shortcodes.php' );
    }
}
